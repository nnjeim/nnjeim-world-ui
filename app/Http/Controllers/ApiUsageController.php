<?php

namespace App\Http\Controllers;

use App\Services\ApiUsageMetrics;
use Illuminate\Http\JsonResponse;

final class ApiUsageController extends Controller
{
    public function __invoke(ApiUsageMetrics $metrics): JsonResponse
    {
        return response()->json($metrics->summary())
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }
}
