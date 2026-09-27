<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SeoResponseHeadersTest extends TestCase
{
    public function test_api_responses_are_excluded_from_search_results(): void
    {
        Route::get('/api/seo-test', fn () => response()->json(['success' => true]));

        $response = $this->getJson('/api/seo-test');

        $response
            ->assertOk()
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow');
    }

    public function test_documentation_pages_remain_indexable(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertHeaderMissing('X-Robots-Tag')
            ->assertSee('name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"', false);
    }
}
