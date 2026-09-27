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
            ->assertSeeText('The world,')
            ->assertSeeText('Version 1.1.39 is available')
            ->assertSeeText('Start with a country selector.')
            ->assertSeeTextInOrder(['Blade', 'React', 'Angular', 'Vue'])
            ->assertSeeText('Browse component docs')
            ->assertSee('data-country-selector', false)
            ->assertSee('brand/world-logo.jpg', false)
            ->assertSee('favicon.svg', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('composer require nnjeim/world');
    }
}
