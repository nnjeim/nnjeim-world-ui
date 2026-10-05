<?php

namespace Tests\Feature;

use App\Services\ApiUsageMetrics;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ApiUsageTest extends TestCase
{
    public function test_hosted_api_responses_are_counted_without_counting_the_widget_or_health_check(): void
    {
        $this->travelTo(CarbonImmutable::parse('2026-10-05 12:00:00', 'UTC'));
        Route::get('/api/usage-test', fn () => response()->json(['ok' => true]));
        Route::get('/api/usage-test-limited', fn () => response()->json(['ok' => false], 429));
        Route::get('/api/usage-test-error', fn () => response()->json(['ok' => false], 500));

        $this->getJson('/api/usage-test?search=private')->assertOk();
        $this->getJson('/api/usage-test-limited')->assertTooManyRequests();
        $this->getJson('/api/usage-test-error')->assertInternalServerError();
        $this->get('/up')->assertOk();

        $response = $this->getJson('/api-usage');

        $response
            ->assertOk()
            ->assertHeader('Cache-Control', 'max-age=300, public, s-maxage=300')
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow')
            ->assertHeaderMissing('Set-Cookie')
            ->assertJsonPath('window_days', 30)
            ->assertJsonPath('requests', 3)
            ->assertJsonPath('success_rate_percent', 33.3)
            ->assertJsonPath('daily.29.date', '2026-10-05')
            ->assertJsonPath('daily.29.requests', 3);

        $this->assertSame(3, Cache::get('world-api-usage:v1:2026-10-05:endpoint:other'));
        $this->assertSame(1, Cache::get('world-api-usage:v1:2026-10-05:rate_limited'));

        $this->getJson('/api-usage')->assertJsonPath('requests', 3);
    }

    public function test_summary_excludes_older_days_and_uses_the_p95_latency_bucket(): void
    {
        $metrics = app(ApiUsageMetrics::class);
        $this->travelTo(CarbonImmutable::parse('2026-09-05 12:00:00', 'UTC'));
        $metrics->record('countries', 200, 30);

        $this->travelTo(CarbonImmutable::parse('2026-10-05 12:00:00', 'UTC'));

        for ($request = 0; $request < 19; $request++) {
            $metrics->record('countries', 200, 120);
        }

        $metrics->record('countries', 503, 6500);

        $response = $this->getJson('/api-usage');

        $response
            ->assertOk()
            ->assertJsonPath('requests', 20)
            ->assertJsonPath('success_rate_percent', 95)
            ->assertJsonPath('p95_latency_ms', 200)
            ->assertJsonPath('p95_latency_overflow', false)
            ->assertJsonPath('daily.0.date', '2026-09-06')
            ->assertJsonPath('daily.0.requests', 0);
    }
}
