<?php

namespace App\Support;

final class ComponentCatalog
{
    public const DEFAULT_SLUG = 'country-selector';

    /**
     * @return array<string, array<string, mixed>>
     */
    public static function all(): array
    {
        return [
            'country-selector' => [
                'title' => 'Country selector',
                'summary' => 'A searchable, keyboard-friendly selector backed by the complete World country dataset.',
                'status' => 'Stable',
                'preview' => 'country',
                'endpoint' => '/api/countries',
                'example_url' => '/api/countries?fields=iso2&search=rom',
                'api_fields' => 'id, name, iso2',
                'features' => ['Client-side search', 'ISO code and flag', 'Keyboard navigation', 'Single API request'],
                'props' => [
                    ['name' => 'name', 'type' => 'string', 'default' => 'country_id', 'description' => 'Submitted form-field name.'],
                    ['name' => 'value', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected country ID.'],
                    ['name' => 'required', 'type' => 'boolean', 'default' => 'false', 'description' => 'Marks the control as required.'],
                    ['name' => 'disabled', 'type' => 'boolean', 'default' => 'false', 'description' => 'Prevents selection changes.'],
                ],
                'events' => [
                    ['name' => 'change', 'payload' => 'Country', 'description' => 'Emitted after a country is selected.'],
                    ['name' => 'loading', 'payload' => 'boolean', 'description' => 'Reports API loading state.'],
                    ['name' => 'error', 'payload' => 'Error', 'description' => 'Reports an unavailable or invalid response.'],
                ],
                'validation' => ['Submit the numeric country ID.', 'Resolve the ID against your local countries table.', 'Use `required` only when the product flow requires a country.'],
                'accessibility' => ['Associate a visible label with the control.', 'Expose expanded state and the active option on custom comboboxes.', 'Support Arrow keys, Enter, and Escape.', 'Announce loading, empty, and selected states.'],
            ],
            'location-selector' => [
                'title' => 'Country, state, and city selector',
                'summary' => 'Three dependent selectors that progressively narrow the dataset without loading every city up front.',
                'status' => 'Beta',
                'preview' => 'location',
                'endpoint' => '/api/states',
                'example_url' => '/api/states?filters[country_code]=RO&fields=country_code',
                'api_fields' => 'country.id, country.iso2, state.id, city.id',
                'features' => ['Dependent loading', 'Country-code filtering', 'Small responses', 'Reset-safe state'],
                'props' => [
                    ['name' => 'country', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected country ID.'],
                    ['name' => 'state', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected state ID.'],
                    ['name' => 'city', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected city ID.'],
                    ['name' => 'required', 'type' => 'boolean', 'default' => 'false', 'description' => 'Requires every enabled level.'],
                ],
                'events' => [
                    ['name' => 'country-change', 'payload' => 'Country', 'description' => 'Resets state and city before loading states.'],
                    ['name' => 'state-change', 'payload' => 'State', 'description' => 'Resets city before loading cities.'],
                    ['name' => 'change', 'payload' => 'Location', 'description' => 'Emits the complete selected location.'],
                ],
                'validation' => ['Validate each ID independently.', 'Confirm the state belongs to the submitted country.', 'Confirm the city belongs to the submitted state.'],
                'accessibility' => ['Keep disabled dependent fields in the tab order only when actionable.', 'Announce loading before enabling the next field.', 'Preserve visible labels for all three selectors.', 'Move focus only when the user explicitly requests it.'],
            ],
            'currency-selector' => [
                'title' => 'Currency selector',
                'summary' => 'Choose a currency with its ISO code and native symbol, sourced from the World currency endpoint.',
                'status' => 'Stable',
                'preview' => 'currency',
                'endpoint' => '/api/currencies',
                'example_url' => '/api/currencies?fields=code,symbol',
                'api_fields' => 'id, name, code, symbol',
                'features' => ['ISO 4217 codes', 'Native symbols', 'Search-ready labels', '250 country mappings'],
                'props' => [
                    ['name' => 'name', 'type' => 'string', 'default' => 'currency_id', 'description' => 'Submitted form-field name.'],
                    ['name' => 'value', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected currency ID.'],
                    ['name' => 'showSymbol', 'type' => 'boolean', 'default' => 'true', 'description' => 'Includes the native currency symbol.'],
                    ['name' => 'disabled', 'type' => 'boolean', 'default' => 'false', 'description' => 'Prevents selection changes.'],
                ],
                'events' => [
                    ['name' => 'change', 'payload' => 'Currency', 'description' => 'Emitted after a currency is selected.'],
                    ['name' => 'loading', 'payload' => 'boolean', 'description' => 'Reports API loading state.'],
                    ['name' => 'error', 'payload' => 'Error', 'description' => 'Reports an unavailable or invalid response.'],
                ],
                'validation' => ['Submit the numeric currency ID.', 'Use the currency code for external integrations.', 'Store monetary values separately from presentation symbols.'],
                'accessibility' => ['Do not use a symbol as the only currency label.', 'Include both the currency name and ISO code.', 'Expose loading and failure states.', 'Keep option text unambiguous.'],
            ],
            'language-selector' => [
                'title' => 'Language selector',
                'summary' => 'Present language names in English and their native form, including text-direction metadata.',
                'status' => 'Stable',
                'preview' => 'language',
                'endpoint' => '/api/languages',
                'example_url' => '/api/languages?fields=name_native,dir',
                'api_fields' => 'id, code, name, name_native, dir',
                'features' => ['183 languages', 'Native names', 'Direction metadata', 'ISO language codes'],
                'props' => [
                    ['name' => 'name', 'type' => 'string', 'default' => 'language_id', 'description' => 'Submitted form-field name.'],
                    ['name' => 'value', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected language ID.'],
                    ['name' => 'nativeNames', 'type' => 'boolean', 'default' => 'true', 'description' => 'Displays each native language name.'],
                    ['name' => 'disabled', 'type' => 'boolean', 'default' => 'false', 'description' => 'Prevents selection changes.'],
                ],
                'events' => [
                    ['name' => 'change', 'payload' => 'Language', 'description' => 'Emitted after a language is selected.'],
                    ['name' => 'direction-change', 'payload' => 'ltr|rtl', 'description' => 'Exposes the selected writing direction.'],
                    ['name' => 'error', 'payload' => 'Error', 'description' => 'Reports an unavailable or invalid response.'],
                ],
                'validation' => ['Submit the numeric language ID.', 'Validate supported product locales separately.', 'Treat text direction as display metadata, not user input.'],
                'accessibility' => ['Set the option direction from the returned metadata.', 'Keep the English name available for recognition.', 'Do not infer locale support from the full language dataset.', 'Announce the selected native name.'],
            ],
            'timezone-selector' => [
                'title' => 'Timezone selector',
                'summary' => 'Select an IANA timezone from World’s normalized timezone dataset.',
                'status' => 'Stable',
                'preview' => 'timezone',
                'endpoint' => '/api/timezones',
                'example_url' => '/api/timezones?search=Europe/Bucharest',
                'api_fields' => 'id, name',
                'features' => ['IANA identifiers', '428 zones', 'Searchable names', 'Country relationships'],
                'props' => [
                    ['name' => 'name', 'type' => 'string', 'default' => 'timezone_id', 'description' => 'Submitted form-field name.'],
                    ['name' => 'value', 'type' => 'number|null', 'default' => 'null', 'description' => 'Initially selected timezone ID.'],
                    ['name' => 'search', 'type' => 'boolean', 'default' => 'true', 'description' => 'Enables filtering by IANA name.'],
                    ['name' => 'disabled', 'type' => 'boolean', 'default' => 'false', 'description' => 'Prevents selection changes.'],
                ],
                'events' => [
                    ['name' => 'change', 'payload' => 'Timezone', 'description' => 'Emitted after a timezone is selected.'],
                    ['name' => 'loading', 'payload' => 'boolean', 'description' => 'Reports API loading state.'],
                    ['name' => 'error', 'payload' => 'Error', 'description' => 'Reports an unavailable or invalid response.'],
                ],
                'validation' => ['Submit the numeric timezone ID or canonical IANA name.', 'Resolve offsets at runtime because daylight saving rules change.', 'Store timestamps in UTC.'],
                'accessibility' => ['Read slash-separated names as human-readable labels.', 'Expose search results count.', 'Keep the canonical IANA value available.', 'Do not communicate UTC offset by color alone.'],
            ],
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function find(string $slug): ?array
    {
        return self::all()[$slug] ?? null;
    }
}
