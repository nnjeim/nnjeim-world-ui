<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $component['summary'] }}">
    <meta name="theme-color" content="#f45143">

    <meta property="og:title" content="{{ $component['title'] }} — World components">
    <meta property="og:description" content="{{ $component['summary'] }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ route('components.show', $slug) }}">
    <meta property="og:image" content="{{ asset('og/world-ui.png') }}">
    <meta name="twitter:card" content="summary_large_image">

    <title>{{ $component['title'] }} — World components</title>

    <link rel="canonical" href="{{ route('components.show', $slug) }}">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" sizes="180x180">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'TechArticle',
            'headline' => $component['title'].' component',
            'description' => $component['summary'],
            'url' => route('components.show', $slug),
            'isPartOf' => [
                '@type' => 'WebSite',
                'name' => 'World for Laravel',
                'url' => url('/'),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
</head>
<body class="brand-shell bg-white text-slate-900 antialiased selection:bg-[#f45143] selection:text-white">
    <div class="relative isolate min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[36rem] bg-[radial-gradient(circle_at_76%_8%,rgba(244,81,67,.12),transparent_32%),radial-gradient(circle_at_24%_18%,rgba(251,146,60,.08),transparent_30%)]"></div>
        <x-site-header />

        <main data-component-page="{{ $slug }}">
            <div class="border-b border-white/8 bg-white/[.02]">
                <div class="mx-auto max-w-7xl px-5 py-10 sm:px-8">
                    <nav class="flex items-center gap-2 text-xs text-slate-500" aria-label="Breadcrumb">
                        <a href="{{ route('home') }}" class="transition hover:text-white">World</a>
                        <span aria-hidden="true">/</span>
                        <a href="{{ route('components.index') }}" class="transition hover:text-white">Components</a>
                        <span aria-hidden="true">/</span>
                        <span class="text-slate-300">{{ $component['title'] }}</span>
                    </nav>
                </div>
            </div>

            <div class="mx-auto grid max-w-7xl gap-12 px-5 py-12 sm:px-8 lg:grid-cols-[16rem_minmax(0,1fr)] lg:py-16">
                <aside class="lg:sticky lg:top-24 lg:self-start" aria-label="Component navigation">
                    <div class="flex items-center justify-between lg:block">
                        <p class="text-xs font-semibold uppercase tracking-[.18em] text-slate-500">Components</p>
                        <span class="text-xs text-slate-600 lg:mt-2 lg:block">Version 1.1.39</span>
                    </div>
                    <nav class="mt-4 flex gap-2 overflow-x-auto pb-2 lg:flex-col lg:overflow-visible" aria-label="World components">
                        @foreach ($components as $componentSlug => $navigationComponent)
                            <a href="{{ route('components.show', $componentSlug) }}" class="group min-w-52 rounded-xl border px-3.5 py-3 transition lg:min-w-0 {{ $componentSlug === $slug ? 'border-cyan-300/25 bg-cyan-300/8' : 'border-transparent hover:border-white/8 hover:bg-white/4' }}" @if ($componentSlug === $slug) aria-current="page" @endif>
                                <span class="flex items-center justify-between gap-3">
                                    <span class="text-sm font-medium {{ $componentSlug === $slug ? 'text-white' : 'text-slate-300 group-hover:text-white' }}">{{ $navigationComponent['title'] }}</span>
                                    <span class="size-1.5 shrink-0 rounded-full {{ $navigationComponent['status'] === 'Beta' ? 'bg-amber-300' : 'bg-emerald-400' }}"></span>
                                </span>
                                <span class="mt-1 block truncate text-xs text-slate-600">{{ $navigationComponent['endpoint'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </aside>

                <article class="min-w-0">
                    <header class="max-w-4xl">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full border border-cyan-300/20 bg-cyan-300/8 px-2.5 py-1 text-xs font-medium text-cyan-200">{{ $component['status'] }}</span>
                            <span class="rounded-full border border-white/8 bg-white/4 px-2.5 py-1 font-mono text-xs text-slate-400">{{ $component['endpoint'] }}</span>
                        </div>
                        <h1 class="mt-5 text-4xl font-semibold tracking-[-.04em] text-white sm:text-5xl">{{ $component['title'] }}</h1>
                        <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-400">{{ $component['summary'] }}</p>
                        <div class="mt-7 flex flex-wrap gap-2">
                            @foreach ($component['features'] as $feature)
                                <span class="rounded-lg border border-white/8 bg-white/4 px-3 py-1.5 text-xs text-slate-300">{{ $feature }}</span>
                            @endforeach
                        </div>
                    </header>

                    <section class="mt-12" aria-labelledby="installation-heading">
                        <div class="flex items-end justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[.18em] text-cyan-300">Installation</p>
                                <h2 id="installation-heading" class="mt-2 text-2xl font-semibold text-white">Install once, use everywhere.</h2>
                            </div>
                            <a href="https://github.com/nnjeim/world#installation" target="_blank" rel="noreferrer" class="hidden text-sm font-medium text-cyan-300 transition hover:text-cyan-200 sm:inline">Package setup →</a>
                        </div>
                        <div class="mt-5 grid gap-3 sm:grid-cols-2">
                            @foreach (['composer require nnjeim/world', 'php artisan world:install'] as $command)
                                <div class="flex min-w-0 items-center justify-between gap-4 rounded-xl border border-white/8 bg-slate-900/70 px-4 py-3">
                                    <code class="truncate font-mono text-sm text-slate-300">{{ $command }}</code>
                                    <button type="button" data-copy-text="{{ $command }}" class="copy-action shrink-0 rounded-md px-2 py-1 text-xs text-slate-500 transition hover:bg-white/8 hover:text-white"><span data-copy-label>Copy</span></button>
                                </div>
                            @endforeach
                        </div>
                        <p class="mt-3 text-sm text-slate-500">React, Angular, and Vue consume the same Laravel API; no frontend package is required.</p>
                    </section>

                    <section class="mt-16" aria-labelledby="playground-heading">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[.18em] text-cyan-300">Playground</p>
                            <h2 id="playground-heading" class="mt-2 text-2xl font-semibold text-white">Live behavior and copy-ready code.</h2>
                        </div>

                        <div class="mt-6 overflow-hidden rounded-2xl border border-white/10 bg-slate-900/65 shadow-2xl shadow-black/20 ring-1 ring-white/5">
                            <div class="flex flex-col justify-between gap-4 border-b border-white/8 px-5 py-4 sm:flex-row sm:items-center">
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $component['title'] }}</p>
                                    <p data-demo-status class="mt-0.5 text-xs text-slate-500" aria-live="polite">Connecting to the World API…</p>
                                </div>
                                <div class="flex overflow-x-auto rounded-lg border border-white/8 bg-slate-950/60 p-1" role="tablist" aria-label="Framework examples">
                                    @foreach (['blade' => 'Blade', 'react' => 'React', 'angular' => 'Angular', 'vue' => 'Vue'] as $framework => $label)
                                        <button type="button" role="tab" data-catalog-framework="{{ $framework }}" aria-selected="{{ $framework === 'blade' ? 'true' : 'false' }}" class="framework-tab whitespace-nowrap rounded-md px-3.5 py-2 text-xs font-medium transition {{ $framework === 'blade' ? 'is-active' : '' }}">{{ $label }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="grid lg:grid-cols-[.85fr_1.15fr]">
                                <div class="relative min-h-[30rem] border-b border-white/8 bg-slate-100 p-5 text-slate-900 sm:p-8 lg:border-b-0 lg:border-r lg:border-white/8">
                                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(244,81,67,.09),transparent_35%),linear-gradient(to_right,rgba(15,23,42,.045)_1px,transparent_1px),linear-gradient(to_bottom,rgba(15,23,42,.045)_1px,transparent_1px)] bg-[size:auto,24px_24px,24px_24px]"></div>
                                    <div class="relative mx-auto max-w-md">
                                        <span class="rounded-full bg-white px-3 py-1 text-xs font-medium text-slate-500 shadow-sm ring-1 ring-slate-200">Live preview</span>

                                        @if ($component['preview'] === 'location')
                                            <div class="mt-8 grid gap-5" data-location-demo>
                                                @foreach ([['country', 'Country'], ['state', 'State or region'], ['city', 'City']] as [$field, $label])
                                                    <label class="grid gap-2 text-sm font-semibold text-slate-800">
                                                        {{ $label }}
                                                        <select data-location-{{ $field }} class="h-12 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm font-medium shadow-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10" {{ $field !== 'country' ? 'disabled' : '' }}>
                                                            <option>Loading…</option>
                                                        </select>
                                                    </label>
                                                @endforeach
                                                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selected location</p>
                                                    <p data-location-result class="mt-2 text-sm font-semibold text-slate-900">Romania · Cluj County · Cluj-Napoca</p>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-8" data-single-select-demo="{{ $component['preview'] }}">
                                                <label for="demo-search" class="text-sm font-semibold text-slate-800">Search {{ strtolower($component['title']) }}</label>
                                                <input id="demo-search" data-demo-search type="search" class="mt-2 h-11 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm shadow-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10" placeholder="Type to filter…">
                                                <label for="demo-select" class="mt-5 block text-sm font-semibold text-slate-800">Result</label>
                                                <select id="demo-select" data-demo-select class="mt-2 h-12 w-full rounded-xl border border-slate-300 bg-white px-3 text-sm font-medium shadow-sm outline-none transition focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10">
                                                    <option>Loading…</option>
                                                </select>
                                                <div class="mt-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                                                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Selected value</p>
                                                    <p data-demo-result class="mt-2 text-sm font-semibold text-slate-900">Loading…</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="code-panel flex min-h-[30rem] min-w-0 flex-col bg-[#151a23]">
                                    <div class="flex items-center justify-between border-b border-white/8 px-5 py-3.5">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span class="size-2 rounded-full bg-cyan-300"></span>
                                            <span data-catalog-filename class="truncate font-mono text-xs text-slate-400">component.blade.php</span>
                                        </div>
                                        <button type="button" data-copy-catalog-code class="copy-action inline-flex items-center gap-1.5 rounded-md border border-white/8 bg-white/5 px-2.5 py-1.5 text-xs text-slate-400 transition hover:bg-white/10 hover:text-white">
                                            <span data-copy-label>Copy code</span>
                                        </button>
                                    </div>
                                    <pre class="code-window flex-1 overflow-auto p-5 text-[13px] leading-7 sm:p-6"><code data-catalog-code class="font-mono text-slate-300">Loading example…</code></pre>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mt-16" aria-labelledby="api-heading">
                        <p class="text-xs font-semibold uppercase tracking-[.18em] text-cyan-300">API reference</p>
                        <h2 id="api-heading" class="mt-2 text-2xl font-semibold text-white">Request only the fields you need.</h2>
                        <div class="mt-6 overflow-hidden rounded-xl border border-white/8 bg-slate-900/60">
                            <div class="flex flex-col justify-between gap-4 border-b border-white/8 px-5 py-4 sm:flex-row sm:items-center">
                                <code class="font-mono text-sm text-cyan-300">GET {{ $component['example_url'] }}</code>
                                <button type="button" data-copy-text="{{ url($component['example_url']) }}" class="copy-action self-start rounded-md px-2 py-1 text-xs text-slate-500 transition hover:bg-white/8 hover:text-white"><span data-copy-label>Copy URL</span></button>
                            </div>
                            <dl class="grid gap-px bg-white/8 sm:grid-cols-2">
                                <div class="bg-slate-950/80 p-5">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Endpoint</dt>
                                    <dd class="mt-2 font-mono text-sm text-slate-300">{{ $component['endpoint'] }}</dd>
                                </div>
                                <div class="bg-slate-950/80 p-5">
                                    <dt class="text-xs font-semibold uppercase tracking-wider text-slate-500">Fields used</dt>
                                    <dd class="mt-2 font-mono text-sm text-slate-300">{{ $component['api_fields'] }}</dd>
                                </div>
                            </dl>
                        </div>
                    </section>

                    <section class="mt-16" aria-labelledby="props-heading">
                        <p class="text-xs font-semibold uppercase tracking-[.18em] text-cyan-300">Component contract</p>
                        <h2 id="props-heading" class="mt-2 text-2xl font-semibold text-white">Props</h2>
                        <div class="mt-6 overflow-x-auto rounded-xl border border-white/8">
                            <table class="w-full min-w-[42rem] text-left text-sm">
                                <thead class="bg-white/4 text-xs uppercase tracking-wider text-slate-500">
                                    <tr><th class="px-4 py-3">Name</th><th class="px-4 py-3">Type</th><th class="px-4 py-3">Default</th><th class="px-4 py-3">Description</th></tr>
                                </thead>
                                <tbody class="divide-y divide-white/8">
                                    @foreach ($component['props'] as $prop)
                                        <tr class="bg-slate-900/35">
                                            <td class="px-4 py-3 font-mono text-cyan-300">{{ $prop['name'] }}</td>
                                            <td class="px-4 py-3 font-mono text-slate-400">{{ $prop['type'] }}</td>
                                            <td class="px-4 py-3 font-mono text-slate-400">{{ $prop['default'] }}</td>
                                            <td class="px-4 py-3 text-slate-400">{{ $prop['description'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <section class="mt-12" aria-labelledby="events-heading">
                        <h2 id="events-heading" class="text-2xl font-semibold text-white">Events</h2>
                        <div class="mt-6 grid gap-3">
                            @foreach ($component['events'] as $event)
                                <div class="grid gap-2 rounded-xl border border-white/8 bg-white/[.025] p-4 sm:grid-cols-[10rem_9rem_1fr] sm:items-center">
                                    <code class="text-sm text-cyan-300">{{ $event['name'] }}</code>
                                    <code class="text-xs text-violet-300">{{ $event['payload'] }}</code>
                                    <p class="text-sm text-slate-400">{{ $event['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <div class="mt-12 grid gap-6 lg:grid-cols-2">
                        <section class="rounded-2xl border border-white/8 bg-white/[.025] p-6" aria-labelledby="validation-heading">
                            <h2 id="validation-heading" class="text-lg font-semibold text-white">Validation guidance</h2>
                            <ul class="mt-5 grid gap-3 text-sm leading-6 text-slate-400">
                                @foreach ($component['validation'] as $item)
                                    <li class="flex gap-3"><span class="mt-2 size-1.5 shrink-0 rounded-full bg-cyan-300"></span><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </section>
                        <section class="rounded-2xl border border-white/8 bg-white/[.025] p-6" aria-labelledby="accessibility-heading">
                            <h2 id="accessibility-heading" class="text-lg font-semibold text-white">Accessibility checklist</h2>
                            <ul class="mt-5 grid gap-3 text-sm leading-6 text-slate-400">
                                @foreach ($component['accessibility'] as $item)
                                    <li class="flex gap-3"><span class="mt-1 grid size-4 shrink-0 place-items-center rounded-full bg-emerald-400/10 text-[10px] text-emerald-300">✓</span><span>{{ $item }}</span></li>
                                @endforeach
                            </ul>
                        </section>
                    </div>
                </article>
            </div>
        </main>

        <x-site-footer />
    </div>
</body>
</html>
