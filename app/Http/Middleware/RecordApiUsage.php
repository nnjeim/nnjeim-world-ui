<?php

namespace App\Http\Middleware;

use App\Services\ApiUsageMetrics;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class RecordApiUsage
{
    public function __construct(private ApiUsageMetrics $metrics) {}

    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            $request->attributes->set('api_usage_started_at', hrtime(true));
        }

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $request->is('api/*')) {
            return;
        }

        $endpoint = match ($request->path()) {
            'api/countries' => 'countries',
            'api/states' => 'states',
            'api/cities' => 'cities',
            'api/currencies' => 'currencies',
            'api/timezones' => 'timezones',
            'api/languages' => 'languages',
            'api/geolocate' => 'geolocate',
            default => 'other',
        };

        $startedAt = $request->attributes->get('api_usage_started_at');
        $durationMs = is_int($startedAt) ? max(0, (int) ceil((hrtime(true) - $startedAt) / 1_000_000)) : 0;

        try {
            $this->metrics->record($endpoint, $response->getStatusCode(), $durationMs);
        } catch (Throwable $exception) {
            Log::warning('API usage recording failed', ['exception' => $exception]);
        }
    }
}
