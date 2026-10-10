<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_presents_the_package_and_component_showcase(): void
    {
        config(['world_ui.package_version' => '2.0.0', 'world_ui.release_preview' => false]);

        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertHeader('Cache-Control', 'max-age=300, public, s-maxage=3600, stale-while-revalidate=86400')
            ->assertSeeText('The world,')
            ->assertSeeText('Version 2.0.0 is available')
            ->assertSeeText('Start with a country selector.')
            ->assertSeeText('API activity')
            ->assertSee('data-api-usage', false)
            ->assertSeeTextInOrder(['Blade', 'React', 'Angular', 'Vue'])
            ->assertSeeText('Browse component docs')
            ->assertSee('data-country-selector', false)
            ->assertSee('brand/world-logo.jpg', false)
            ->assertSee('favicon.svg', false)
            ->assertSee('<title>Laravel Countries, States &amp; Cities Package — World</title>', false)
            ->assertSee('max-image-preview:large', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('composer require nnjeim/world:^2.0')
            ->assertSeeText('2.0 upgrade guide')
            ->assertSeeText('1.x documentation');

        $this->assertFalse($response->headers->has('Set-Cookie'));
    }

    public function test_release_preview_links_to_the_tested_code_without_claiming_a_published_release(): void
    {
        config([
            'world_ui.package_version' => '2.0.0',
            'world_ui.release_preview' => true,
            'world_ui.release_url' => 'https://github.com/nnjeim/world/tree/tested-commit',
        ]);

        $response = $this->get('/');

        $response
            ->assertSeeText('World 2.0.0 release preview')
            ->assertDontSeeText('Version 2.0.0 is available')
            ->assertSee('https://github.com/nnjeim/world/tree/tested-commit');
    }
}
