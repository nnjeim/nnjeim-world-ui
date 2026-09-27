<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ComponentPageTest extends TestCase
{
    public function test_component_index_redirects_to_the_country_selector(): void
    {
        $response = $this->get('/components');

        $response->assertRedirect('/components/country-selector');
    }

    #[DataProvider('components')]
    public function test_component_page_renders_its_documentation_and_live_demo(
        string $slug,
        string $title,
        string $endpoint,
    ): void {
        $response = $this->get('/components/'.$slug);

        $response
            ->assertOk()
            ->assertViewIs('components.show')
            ->assertViewHas('slug', $slug)
            ->assertSeeText($title)
            ->assertSeeText($endpoint)
            ->assertSeeTextInOrder(['Blade', 'React', 'Angular', 'Vue'])
            ->assertSeeText('Accessibility checklist')
            ->assertSee('data-component-page="'.$slug.'"', false);
    }

    public function test_unknown_component_returns_404(): void
    {
        $response = $this->get('/components/not-a-component');

        $response->assertNotFound();
    }

    /**
     * @return array<string, array{string, string, string}>
     */
    public static function components(): array
    {
        return [
            'country selector' => ['country-selector', 'Country selector', '/api/countries'],
            'location selector' => ['location-selector', 'Country, state, and city selector', '/api/states'],
            'currency selector' => ['currency-selector', 'Currency selector', '/api/currencies'],
            'language selector' => ['language-selector', 'Language selector', '/api/languages'],
            'timezone selector' => ['timezone-selector', 'Timezone selector', '/api/timezones'],
        ];
    }
}
