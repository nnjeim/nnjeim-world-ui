<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Explore accessible country, location, currency, language, and timezone selectors for Laravel, Blade, React, Angular, and Vue.">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="theme-color" content="#f45143">

    <meta property="og:title" content="Laravel Geographic UI Components — World">
    <meta property="og:description" content="Live, accessible geographic selectors with copy-ready examples for Blade, React, Angular, and Vue.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ route('components.index') }}">
    <meta property="og:site_name" content="World for Laravel">
    <meta property="og:locale" content="en_US">
    <meta property="og:image" content="{{ asset('og/world-ui.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="World geographic UI component library">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Laravel Geographic UI Components — World">
    <meta name="twitter:description" content="Live geographic selectors with copy-ready examples for Blade, React, Angular, and Vue.">
    <meta name="twitter:image" content="{{ asset('og/world-ui.png') }}">
    <meta name="twitter:image:alt" content="World geographic UI component library">

    <title>Laravel Geographic UI Components — World</title>

    <link rel="canonical" href="{{ route('components.index') }}">
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
                    '@type' => 'CollectionPage',
                    '@id' => route('components.index').'#page',
                    'name' => 'World geographic UI components',
                    'description' => 'Accessible geographic selectors with examples for Laravel, Blade, React, Angular, and Vue.',
                    'url' => route('components.index'),
                    'isPartOf' => [
                        '@type' => 'WebSite',
                        '@id' => url('/').'#website',
                        'name' => 'World for Laravel',
                        'url' => url('/'),
                    ],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($components),
                        'itemListElement' => collect($components)->keys()->values()->map(fn (string $slug, int $index): array => [
                            '@type' => 'ListItem',
                            'position' => $index + 1,
                            'url' => route('components.show', $slug),
                            'name' => $components[$slug]['title'],
                        ])->all(),
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'World',
                            'item' => route('home'),
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Components',
                            'item' => route('components.index'),
                        ],
                    ],
                ],
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>
<body class="brand-shell bg-white text-slate-900 antialiased selection:bg-[#f45143] selection:text-white">
    <div class="relative isolate min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[38rem] bg-[radial-gradient(circle_at_76%_8%,rgba(244,81,67,.12),transparent_32%),radial-gradient(circle_at_24%_18%,rgba(251,146,60,.08),transparent_30%)]"></div>

        <x-site-header />

        <main>
            <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8 lg:py-28">
                <div class="max-w-4xl">
                    <p class="text-sm font-semibold uppercase tracking-[.18em] text-[#f45143]">World component library</p>
                    <h1 class="mt-5 text-5xl font-semibold tracking-[-.045em] text-white sm:text-6xl">Geographic UI components for Laravel and JavaScript.</h1>
                    <p class="mt-6 max-w-3xl text-lg leading-8 text-slate-400">Explore live selectors powered by the World API, compare Blade, React, Angular, and Vue implementations, and copy production-minded examples into your application.</p>
                </div>

                <div class="mt-12 flex flex-wrap gap-2" aria-label="Supported frameworks">
                    @foreach (['Laravel Blade', 'React', 'Angular', 'Vue'] as $framework)
                        <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-sm text-slate-300">{{ $framework }}</span>
                    @endforeach
                </div>
            </section>

            <section class="border-y border-white/8 bg-white/[.025]">
                <div class="mx-auto max-w-7xl px-5 py-20 sm:px-8 lg:py-24">
                    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($components as $slug => $component)
                            <a href="{{ route('components.show', $slug) }}" class="group flex min-h-64 flex-col rounded-2xl border border-white/8 bg-slate-950/55 p-6 transition hover:-translate-y-1 hover:border-[#f45143]/30 hover:bg-slate-900">
                                <div class="flex items-center justify-between gap-4">
                                    <span class="rounded-full border border-white/8 bg-white/5 px-2.5 py-1 text-xs font-medium text-slate-400">{{ $component['status'] }}</span>
                                    <span class="font-mono text-xs text-[#f45143]">{{ $component['endpoint'] }}</span>
                                </div>
                                <h2 class="mt-6 text-xl font-semibold text-white transition group-hover:text-[#f45143]">{{ $component['title'] }}</h2>
                                <p class="mt-3 flex-1 text-sm leading-6 text-slate-400">{{ $component['summary'] }}</p>
                                <span class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-[#f45143]">View live example <span aria-hidden="true">→</span></span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="mx-auto max-w-7xl px-5 py-20 sm:px-8 lg:py-24">
                <div class="grid gap-8 rounded-3xl border border-[#f45143]/20 bg-gradient-to-br from-[#f45143]/10 via-orange-100/60 to-white px-6 py-12 sm:px-10 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold text-[#f45143]">Use the same data everywhere</p>
                        <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white">Install World once, then choose the frontend that fits.</h2>
                        <p class="mt-4 max-w-2xl leading-7 text-slate-400">Each example consumes the same Laravel API and follows the same validation and accessibility guidance.</p>
                    </div>
                    <a href="https://github.com/nnjeim/world#installation" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center rounded-xl bg-[#f45143] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#df4438]">Install World</a>
                </div>
            </section>
        </main>

        <x-site-footer />
    </div>
</body>
</html>
