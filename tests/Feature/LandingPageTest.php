<?php

namespace Tests\Feature;

use Tests\TestCase;

class LandingPageTest extends TestCase
{
    public function test_landing_page_presents_the_package_and_component_showcase(): void
    {
        $response = $this->get('/');

        $response
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertHeader('Cache-Control', 'max-age=300, public, s-maxage=3600, stale-while-revalidate=86400')
            ->assertSeeText('The world,')
            ->assertSeeText('Version 1.1.39 is available')
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
            ->assertSee('composer require nnjeim/world');

        $this->assertFalse($response->headers->has('Set-Cookie'));
    }
}
