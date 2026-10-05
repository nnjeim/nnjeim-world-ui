<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;

final class ApiUsageMetrics
{
    private const WINDOW_DAYS = 30;

    private const RETENTION_DAYS = 32;

    private const LATENCY_BUCKETS_MS = [50, 100, 200, 400, 800, 1600, 3200, 6400];

    public function record(string $endpoint, int $statusCode, int $durationMs): void
    {
        $date = CarbonImmutable::now('UTC')->toDateString();
        $status = intdiv($statusCode, 100).'xx';
        $latencyBucket = 'over';

        foreach (self::LATENCY_BUCKETS_MS as $upperBound) {
            if ($durationMs <= $upperBound) {
                $latencyBucket = (string) $upperBound;

                break;
            }
        }

        $keys = [
            $this->key($date, 'requests'),
            $this->key($date, 'status:'.$status),
            $this->key($date, 'endpoint:'.$endpoint),
            $this->key($date, 'latency:'.$latencyBucket),
        ];

        if ($statusCode === 429) {
            $keys[] = $this->key($date, 'rate_limited');
        }

        foreach ($keys as $key) {
            Cache::add($key, 0, CarbonImmutable::now('UTC')->addDays(self::RETENTION_DAYS));
            Cache::increment($key);
        }
    }

    /**
     * @return array{window_days: int, requests: int, success_rate_percent: float|null, p95_latency_ms: int|null, p95_latency_overflow: bool, daily: array<int, array{date: string, requests: int}>, updated_at: string}
     */
    public function summary(): array
    {
        return Cache::remember('world-api-usage:v1:summary', 300, fn (): array => $this->buildSummary());
    }

    /**
     * @return array{window_days: int, requests: int, success_rate_percent: float|null, p95_latency_ms: int|null, p95_latency_overflow: bool, daily: array<int, array{date: string, requests: int}>, updated_at: string}
     */
    private function buildSummary(): array
    {
        $today = CarbonImmutable::now('UTC');
        $dates = [];
        $keys = [];

        for ($daysAgo = self::WINDOW_DAYS - 1; $daysAgo >= 0; $daysAgo--) {
            $date = $today->subDays($daysAgo)->toDateString();
            $dates[] = $date;
            $keys[] = $this->key($date, 'requests');
            $keys[] = $this->key($date, 'status:2xx');

            foreach (self::LATENCY_BUCKETS_MS as $upperBound) {
                $keys[] = $this->key($date, 'latency:'.$upperBound);
            }

            $keys[] = $this->key($date, 'latency:over');
        }

        $values = Cache::many($keys);
        $daily = [];
        $requests = 0;
        $successful = 0;
        $latencyCounts = array_fill_keys([...self::LATENCY_BUCKETS_MS, 'over'], 0);

        foreach ($dates as $date) {
            $count = (int) ($values[$this->key($date, 'requests')] ?? 0);
            $daily[] = ['date' => $date, 'requests' => $count];
            $requests += $count;
            $successful += (int) ($values[$this->key($date, 'status:2xx')] ?? 0);

            foreach ($latencyCounts as $bucket => $_) {
                $latencyCounts[$bucket] += (int) ($values[$this->key($date, 'latency:'.$bucket)] ?? 0);
            }
        }

        $p95LatencyMs = null;
        $p95LatencyOverflow = false;

        if ($requests > 0) {
            $rank = (int) ceil($requests * 0.95);
            $observed = 0;

            foreach ($latencyCounts as $bucket => $count) {
                $observed += $count;

                if ($observed >= $rank) {
                    $p95LatencyOverflow = $bucket === 'over';
                    $p95LatencyMs = $p95LatencyOverflow ? null : (int) $bucket;

                    break;
                }
            }
        }

        return [
            'window_days' => self::WINDOW_DAYS,
            'requests' => $requests,
            'success_rate_percent' => $requests > 0 ? round($successful / $requests * 100, 1) : null,
            'p95_latency_ms' => $p95LatencyMs,
            'p95_latency_overflow' => $p95LatencyOverflow,
            'daily' => $daily,
            'updated_at' => $today->toIso8601String(),
        ];
    }

    private function key(string $date, string $metric): string
    {
        return 'world-api-usage:v1:'.$date.':'.$metric;
    }
}
