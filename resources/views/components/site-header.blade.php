@props(['home' => false])

<header class="sticky top-0 z-50 border-b border-white/8 bg-slate-950/80 backdrop-blur-xl">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-8" aria-label="Primary navigation">
        <a href="{{ $home ? '#top' : route('home') }}" class="group flex items-center gap-3" aria-label="World home">
            <span class="grid size-9 place-items-center rounded-xl bg-gradient-to-br from-cyan-300 to-blue-500 text-slate-950 shadow-lg shadow-cyan-500/15 transition-transform group-hover:-rotate-6">
                <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <circle cx="12" cy="12" r="8.5" />
                    <path d="M3.8 9h16.4M3.8 15h16.4M12 3.5c2.2 2.3 3.2 5.1 3.2 8.5s-1 6.2-3.2 8.5c-2.2-2.3-3.2-5.1-3.2-8.5S9.8 5.8 12 3.5Z" />
                </svg>
            </span>
            <span class="text-lg font-semibold tracking-tight">World</span>
        </a>

        <div class="hidden items-center gap-8 text-sm text-slate-300 md:flex">
            <a href="{{ route('home') }}#overview" class="transition hover:text-white">Overview</a>
            <a href="{{ route('components.index') }}" class="transition hover:text-white {{ request()->routeIs('components.*') ? 'text-white' : '' }}">Components</a>
            <a href="{{ route('home') }}#api" class="transition hover:text-white">API</a>
        </div>

        <a href="https://github.com/nnjeim/world" class="inline-flex items-center gap-2 rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-sm font-medium transition hover:border-white/20 hover:bg-white/10" target="_blank" rel="noreferrer">
            <svg viewBox="0 0 24 24" class="size-4" fill="currentColor" aria-hidden="true"><path d="M12 .8a11.4 11.4 0 0 0-3.6 22.2c.6.1.8-.2.8-.5v-2c-3.3.7-4-1.4-4-1.4-.5-1.4-1.3-1.8-1.3-1.8-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1.1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.7-.3-5.5-1.3-5.5-6A4.7 4.7 0 0 1 5.8 8c-.1-.3-.5-1.6.1-3.4 0 0 1-.3 3.7 1.3a12.7 12.7 0 0 1 6.7 0C19 4.3 20 4.6 20 4.6c.7 1.8.3 3.1.2 3.4a4.7 4.7 0 0 1 1.2 3.2c0 4.7-2.8 5.7-5.5 6 .4.4.8 1.1.8 2.2v3.1c0 .3.2.6.8.5A11.4 11.4 0 0 0 12 .8Z"/></svg>
            <span class="hidden sm:inline">GitHub</span>
        </a>
    </nav>
</header>
