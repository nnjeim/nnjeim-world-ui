<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Add countries, states, cities, currencies, timezones, languages, and IP geolocation to Laravel with World and copy-ready UI examples.">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#f45143">

    <meta property="og:title" content="Laravel Countries, States &amp; Cities Package — World">
    <meta property="og:description" content="Production-ready geographic data for Laravel with copy-ready Blade, React, Angular, and Vue examples.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:site_name" content="World for Laravel">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="{{ asset('og/world-ui.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="World for Laravel geographic data and UI components">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Laravel Countries, States &amp; Cities Package — World">
    <meta name="twitter:description" content="Production-ready geographic data for Laravel with copy-ready UI examples.">
    <meta name="twitter:image" content="{{ asset('og/world-ui.png') }}">
    <meta name="twitter:image:alt" content="World for Laravel geographic data and UI components">

    <title>Laravel Countries, States &amp; Cities Package — World</title>

    <link rel="canonical" href="{{ url('/') }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" sizes="180x180">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebSite',
                    '@id' => url('/').'#website',
                    'name' => 'World for Laravel',
                    'url' => url('/'),
                    'description' => 'Documentation and framework examples for the World Laravel package.',
                ],
                [
                    '@type' => 'SoftwareApplication',
                    '@id' => url('/').'#software',
                    'name' => 'World for Laravel',
                    'description' => 'A Laravel package for countries, states, cities, currencies, timezones, languages, and IP geolocation.',
                    'applicationCategory' => 'DeveloperApplication',
                    'operatingSystem' => 'Any',
                    'softwareVersion' => config('world_ui.package_version'),
                    'url' => url('/'),
                    'image' => asset('og/world-ui.png'),
                    'codeRepository' => 'https://github.com/nnjeim/world',
                    'downloadUrl' => 'https://packagist.org/packages/nnjeim/world',
                    'license' => 'https://opensource.org/licenses/MIT',
                    'offers' => [
                        '@type' => 'Offer',
                        'price' => 0,
                        'priceCurrency' => 'USD',
                    ],
                    'sameAs' => [
                        'https://github.com/nnjeim/world',
                        'https://packagist.org/packages/nnjeim/world',
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>
<body class="brand-shell bg-white text-slate-900 antialiased selection:bg-[#f45143] selection:text-white">
    <div class="relative isolate overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[46rem] bg-[radial-gradient(circle_at_76%_8%,rgba(244,81,67,.13),transparent_32%),radial-gradient(circle_at_24%_22%,rgba(251,146,60,.09),transparent_30%)]"></div>
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[46rem] bg-[linear-gradient(to_right,rgba(100,116,139,.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(100,116,139,.08)_1px,transparent_1px)] bg-[size:48px_48px] [mask-image:linear-gradient(to_bottom,black,transparent)]"></div>

        <x-site-header :home="true" />

        <main id="top">
            <section class="mx-auto grid max-w-7xl items-center gap-16 px-5 pb-24 pt-20 sm:px-8 lg:grid-cols-[1.05fr_.95fr] lg:pb-32 lg:pt-28">
                <div>
                    <div class="mb-7 flex items-center gap-4">
                        <img src="{{ asset('brand/world-logo.jpg') }}" alt="World package logo" class="size-20 rounded-2xl border border-slate-200 bg-white object-cover shadow-lg shadow-[#f45143]/10 sm:size-24">
                        <a href="https://github.com/nnjeim/world/releases/tag/{{ config('world_ui.package_version') }}" target="_blank" rel="noreferrer" class="inline-flex items-center gap-2 rounded-full border border-[#f45143]/20 bg-[#f45143]/8 px-3 py-1.5 text-xs font-medium text-[#d83f33] transition hover:bg-[#f45143]/12">
                            <span class="size-1.5 rounded-full bg-[#f45143] shadow-[0_0_12px_rgba(244,81,67,.55)]"></span>
                            Version {{ config('world_ui.package_version') }} is available
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>

                    <h1 class="max-w-3xl text-5xl font-semibold leading-[1.03] tracking-[-.045em] text-white sm:text-6xl lg:text-7xl">
                        The world,<br>
                        <span class="text-[#f45143]">ready for your UI.</span>
                    </h1>
                    <p class="mt-7 max-w-2xl text-lg leading-8 text-slate-300 sm:text-xl">
                        Countries, states, cities, currencies, timezones, languages, and IP geolocation—packaged for Laravel and exposed through a clean API.
                    </p>

                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                        <a href="#components" class="brand-primary inline-flex items-center justify-center gap-2 rounded-xl bg-[#f45143] px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-[#f45143]/20 transition hover:bg-[#df4438]">
                            Explore the components
                            <span aria-hidden="true">↓</span>
                        </a>
                        <a href="{{ route('components.index') }}" class="inline-flex items-center justify-center rounded-xl border border-white/12 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                            Browse component docs
                        </a>
                    </div>

                    <div class="code-panel mt-10 max-w-xl overflow-hidden rounded-xl border border-slate-800 bg-slate-950 shadow-2xl shadow-slate-900/20">
                        <div class="flex items-center justify-between border-b border-white/8 px-4 py-2.5">
                            <span class="text-xs font-medium text-slate-400">Terminal</span>
                            <button type="button" data-copy-text="composer require nnjeim/world" class="copy-action inline-flex items-center gap-1.5 rounded-md px-2 py-1 text-xs text-slate-400 transition hover:bg-white/8 hover:text-white" aria-label="Copy installation command">
                                <svg viewBox="0 0 24 24" class="size-3.5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="8" y="8" width="11" height="11" rx="2"/><path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2"/></svg>
                                <span data-copy-label>Copy</span>
                            </button>
                        </div>
                        <div class="flex items-center gap-3 px-4 py-4 font-mono text-sm">
                            <span class="select-none text-cyan-300">$</span>
                            <code class="text-slate-200">composer require nnjeim/world</code>
                        </div>
                    </div>
                </div>

                <div class="relative mx-auto w-full max-w-xl lg:mx-0 lg:ml-auto">
                    <div class="absolute -inset-8 -z-10 rounded-full bg-[#f45143]/10 blur-3xl"></div>
                    <div class="code-panel overflow-hidden rounded-2xl border border-slate-800 bg-slate-950 shadow-2xl shadow-slate-900/25 ring-1 ring-slate-900/5">
                        <div class="flex items-center justify-between border-b border-white/8 px-5 py-4">
                            <div class="flex items-center gap-2">
                                <span class="size-2.5 rounded-full bg-rose-400/80"></span>
                                <span class="size-2.5 rounded-full bg-amber-300/80"></span>
                                <span class="size-2.5 rounded-full bg-emerald-400/80"></span>
                            </div>
                            <span class="font-mono text-[11px] text-slate-500">GET /api/countries?search=rom</span>
                        </div>
                        <div class="grid gap-5 p-5 sm:p-7">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-medium uppercase tracking-[.18em] text-slate-500">Response</p>
                                    <p class="mt-1 text-sm font-medium text-emerald-300">200 OK</p>
                                </div>
                                <span class="rounded-full bg-emerald-400/10 px-2.5 py-1 text-xs text-emerald-300">application/json</span>
                            </div>
                            <pre class="overflow-x-auto text-[13px] leading-7 text-slate-300"><code><span class="text-slate-500">{</span>
  <span class="text-sky-300">"success"</span>: <span class="text-amber-300">true</span>,
  <span class="text-sky-300">"message"</span>: <span class="text-emerald-300">"countries"</span>,
  <span class="text-sky-300">"data"</span>: <span class="text-slate-500">[</span>
    <span class="text-slate-500">{</span>
      <span class="text-sky-300">"id"</span>: <span class="text-violet-300">181</span>,
      <span class="text-sky-300">"name"</span>: <span class="text-emerald-300">"Romania"</span>
    <span class="text-slate-500">}</span>
  <span class="text-slate-500">]</span>
<span class="text-slate-500">}</span></code></pre>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -left-5 hidden items-center gap-3 rounded-xl border border-white/10 bg-slate-900/95 px-4 py-3 shadow-xl sm:flex">
                        <span class="grid size-9 place-items-center rounded-lg bg-blue-500/15 text-lg">🌍</span>
                        <div>
                            <p class="text-xs text-slate-500">Coverage</p>
                            <p class="text-sm font-semibold text-white">250 countries</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="overview" class="border-y border-white/8 bg-white/[.025]">
                <div class="mx-auto grid max-w-7xl divide-y divide-white/8 px-5 sm:grid-cols-2 sm:divide-x sm:divide-y-0 sm:px-8 lg:grid-cols-4">
                    <div class="py-8 sm:px-7 sm:first:pl-0">
                        <p class="text-3xl font-semibold tracking-tight text-white">250</p>
                        <p class="mt-1 text-sm text-slate-400">Countries and territories</p>
                    </div>
                    <div class="py-8 sm:px-7">
                        <p class="text-3xl font-semibold tracking-tight text-white">5,000+</p>
                        <p class="mt-1 text-sm text-slate-400">States and regions</p>
                    </div>
                    <div class="py-8 sm:px-7">
                        <p class="text-3xl font-semibold tracking-tight text-white">Laravel 10–13</p>
                        <p class="mt-1 text-sm text-slate-400">Broad framework support</p>
                    </div>
                    <div class="py-8 sm:px-7 sm:last:pr-0">
                        <p class="text-3xl font-semibold tracking-tight text-white">MIT</p>
                        <p class="mt-1 text-sm text-slate-400">Open source license</p>
                    </div>
                </div>
            </section>

            <section id="components" class="mx-auto max-w-7xl px-5 py-24 sm:px-8 lg:py-32">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-cyan-300">Component library</p>
                    <h2 class="mt-4 text-4xl font-semibold tracking-[-.035em] text-white sm:text-5xl">Start with a country selector.</h2>
                    <p class="mt-5 text-lg leading-8 text-slate-400">Try the component against the live World API, choose your framework, then copy the implementation into your application.</p>
                </div>

                <div class="mt-12 overflow-hidden rounded-2xl border border-white/10 bg-slate-900/65 shadow-2xl shadow-black/20 ring-1 ring-white/5">
                    <div class="flex flex-col justify-between gap-4 border-b border-white/8 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
                        <div class="flex items-center gap-3">
                            <span class="grid size-9 place-items-center rounded-lg bg-cyan-300/10 text-cyan-300">
                                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6.5h16M7 11h10M9.5 15.5h5"/><rect x="2.5" y="3" width="19" height="17.5" rx="3"/></svg>
                            </span>
                            <div>
                                <h3 class="text-sm font-semibold text-white">Country selector</h3>
                                <p class="text-xs text-slate-500">Searchable · keyboard accessible · API-backed</p>
                            </div>
                        </div>
                        <div class="flex overflow-x-auto rounded-lg border border-white/8 bg-slate-950/60 p-1" role="tablist" aria-label="Framework examples">
                            @foreach (['blade' => 'Blade', 'react' => 'React', 'angular' => 'Angular', 'vue' => 'Vue'] as $framework => $label)
                                <button type="button" role="tab" data-framework-tab="{{ $framework }}" aria-selected="{{ $framework === 'blade' ? 'true' : 'false' }}" class="framework-tab whitespace-nowrap rounded-md px-3.5 py-2 text-xs font-medium transition {{ $framework === 'blade' ? 'is-active' : '' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid lg:grid-cols-2">
                        <div class="relative min-h-[34rem] border-b border-white/8 bg-slate-100 p-5 text-slate-900 sm:p-10 lg:border-b-0 lg:border-r lg:border-white/8">
                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(244,81,67,.09),transparent_35%),linear-gradient(to_right,rgba(15,23,42,.045)_1px,transparent_1px),linear-gradient(to_bottom,rgba(15,23,42,.045)_1px,transparent_1px)] bg-[size:auto,24px_24px,24px_24px]"></div>
                            <div class="relative mx-auto max-w-md">
                                <div class="mb-8 flex items-center justify-between">
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-500 shadow-sm ring-1 ring-slate-200">Live preview</span>
                                    <span class="inline-flex items-center gap-1.5 text-xs text-slate-500"><span class="size-1.5 rounded-full bg-emerald-500"></span> Live API</span>
                                </div>

                                <div data-country-selector>
                                    <label for="country-search" class="text-sm font-semibold text-slate-800">Country</label>
                                    <p class="mt-1 text-xs text-slate-500">Choose the country for your profile.</p>
                                    <div class="relative mt-3">
                                        <span data-country-input-flag class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xl" aria-hidden="true">🇷🇴</span>
                                        <input id="country-search" data-country-search type="text" value="Romania" role="combobox" aria-autocomplete="list" aria-expanded="false" aria-controls="country-options" autocomplete="off" class="h-12 w-full rounded-xl border border-slate-300 bg-white pl-11 pr-11 text-sm font-medium text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10" placeholder="Search countries...">
                                        <button type="button" data-country-toggle class="absolute right-2 top-1/2 grid size-8 -translate-y-1/2 place-items-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" aria-label="Show countries" tabindex="-1">
                                            <svg viewBox="0 0 24 24" class="size-4 transition" data-country-chevron fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m7 10 5 5 5-5"/></svg>
                                        </button>

                                        <div id="country-options" data-country-options class="absolute z-20 mt-2 hidden w-full overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl shadow-slate-900/15" role="listbox" aria-label="Countries">
                                            <div data-country-loading class="px-4 py-4 text-sm text-slate-500">Loading countries…</div>
                                            <div data-country-list class="max-h-64 overflow-y-auto p-1.5"></div>
                                            <div data-country-empty class="hidden px-4 py-7 text-center text-sm text-slate-500">No countries match your search.</div>
                                        </div>
                                    </div>
                                    <p data-country-status class="mt-2 min-h-5 text-xs text-slate-500" aria-live="polite">Loading 250 countries…</p>

                                    <div class="mt-7 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selected value</span>
                                            <span class="rounded-md bg-emerald-50 px-2 py-1 text-[11px] font-semibold text-emerald-700">Ready to submit</span>
                                        </div>
                                        <div class="mt-4 flex items-center gap-3">
                                            <span data-selected-flag class="grid size-11 place-items-center rounded-lg bg-slate-100 text-2xl">🇷🇴</span>
                                            <div class="min-w-0 flex-1">
                                                <p data-selected-name class="truncate text-sm font-semibold text-slate-900">Romania</p>
                                                <p class="mt-0.5 text-xs text-slate-500">ISO <span data-selected-iso>RO</span> · ID <span data-selected-id>181</span></p>
                                            </div>
                                            <svg viewBox="0 0 24 24" class="size-5 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="code-panel flex min-h-[34rem] min-w-0 flex-col bg-[#151a23]">
                            <div class="flex items-center justify-between border-b border-white/8 px-5 py-3.5">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="size-2 rounded-full bg-cyan-300"></span>
                                    <span data-code-filename class="truncate font-mono text-xs text-slate-400">country-select.blade.php</span>
                                </div>
                                <button type="button" data-copy-code class="copy-action inline-flex items-center gap-1.5 rounded-md border border-white/8 bg-white/5 px-2.5 py-1.5 text-xs text-slate-400 transition hover:bg-white/10 hover:text-white">
                                    <svg viewBox="0 0 24 24" class="size-3.5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="8" y="8" width="11" height="11" rx="2"/><path d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2"/></svg>
                                    <span data-copy-label>Copy code</span>
                                </button>
                            </div>
                            <pre class="code-window flex-1 overflow-auto p-5 text-[13px] leading-7 sm:p-6"><code data-code-block class="font-mono text-slate-300">Loading example…</code></pre>
                        </div>
                    </div>
                </div>
            </section>

            <section id="api" class="border-y border-white/8 bg-white/[.025]">
                <div class="mx-auto max-w-7xl px-5 py-24 sm:px-8 lg:py-28">
                    <div class="grid gap-12 lg:grid-cols-[.8fr_1.2fr] lg:items-start">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[.18em] text-cyan-300">One package, two interfaces</p>
                            <h2 class="mt-4 text-4xl font-semibold tracking-[-.035em] text-white">Use the facade or the API.</h2>
                            <p class="mt-5 leading-7 text-slate-400">Keep geographic data close to your Laravel domain logic, or expose it to any frontend through configurable JSON endpoints.</p>
                            <a href="https://github.com/nnjeim/world#usage" target="_blank" rel="noreferrer" class="mt-7 inline-flex items-center gap-2 text-sm font-semibold text-cyan-300 transition hover:text-cyan-200">Browse all usage examples <span aria-hidden="true">→</span></a>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            @foreach ([
                                ['Countries', '/api/countries', 'Search and filter 250 countries and territories.'],
                                ['States', '/api/states', 'Resolve administrative regions by country.'],
                                ['Cities', '/api/cities', 'Query cities by country or state.'],
                                ['Geolocation', '/api/geolocate', 'Map an IP address to geographic context.'],
                            ] as [$title, $endpoint, $description])
                                <a href="{{ url($endpoint) }}" target="_blank" class="group rounded-xl border border-white/8 bg-slate-950/55 p-5 transition hover:-translate-y-0.5 hover:border-cyan-300/25 hover:bg-slate-900">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-semibold text-white">{{ $title }}</h3>
                                        <span class="text-slate-600 transition group-hover:text-cyan-300" aria-hidden="true">↗</span>
                                    </div>
                                    <code class="mt-3 block text-xs text-cyan-300">GET {{ $endpoint }}</code>
                                    <p class="mt-3 text-sm leading-6 text-slate-500">{{ $description }}</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 py-24 text-center sm:px-8 lg:py-32">
                <div class="relative overflow-hidden rounded-3xl border border-[#f45143]/20 bg-gradient-to-br from-[#f45143]/10 via-orange-100/60 to-white px-6 py-16 sm:px-12">
                    <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(244,81,67,.13),transparent_48%)]"></div>
                    <div class="relative">
                        <p class="text-sm font-semibold text-cyan-300">Build globally from day one</p>
                        <h2 class="mx-auto mt-4 max-w-2xl text-4xl font-semibold tracking-[-.035em] text-white sm:text-5xl">Add World to your next Laravel application.</h2>
                        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                            <button type="button" data-copy-text="composer require nnjeim/world" class="brand-primary copy-action inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-200">
                                <span data-copy-label>Copy install command</span>
                            </button>
                            <a href="https://packagist.org/packages/nnjeim/world" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-xl border border-white/12 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">View on Packagist</a>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <x-site-footer />
    </div>
</body>
</html>
