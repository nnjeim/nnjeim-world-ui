@props(['home' => false])

<header class="sticky top-0 z-50 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl">
    <nav class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-8" aria-label="Primary navigation">
        <a href="{{ $home ? '#top' : route('home') }}" class="group flex items-center gap-3" aria-label="World home">
            <img src="{{ asset('brand/world-logo.jpg') }}" alt="" class="size-10 rounded-xl border border-slate-200 bg-white object-cover shadow-sm transition-transform group-hover:-rotate-3">
            <span class="text-lg font-semibold tracking-tight text-slate-950">World</span>
        </a>

        <div class="hidden items-center gap-8 text-sm text-slate-600 md:flex">
            <a href="{{ route('home') }}#overview" class="transition hover:text-[#f45143]">Overview</a>
            <a href="{{ route('home') }}#activity" class="transition hover:text-[#f45143]">Activity</a>
            <a href="{{ route('components.index') }}" class="transition hover:text-[#f45143] {{ request()->routeIs('components.*') ? 'text-[#f45143]' : '' }}">Components</a>
            <a href="{{ route('home') }}#api" class="transition hover:text-[#f45143]">API</a>
        </div>

        <a href="https://github.com/nnjeim/world" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-[#f45143]/30 hover:text-[#f45143]" target="_blank" rel="noreferrer">
            <svg viewBox="0 0 24 24" class="size-4" fill="currentColor" aria-hidden="true"><path d="M12 .8a11.4 11.4 0 0 0-3.6 22.2c.6.1.8-.2.8-.5v-2c-3.3.7-4-1.4-4-1.4-.5-1.4-1.3-1.8-1.3-1.8-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1.1 1.8 2.8 1.3 3.5 1 .1-.8.4-1.3.8-1.6-2.7-.3-5.5-1.3-5.5-6A4.7 4.7 0 0 1 5.8 8c-.1-.3-.5-1.6.1-3.4 0 0 1-.3 3.7 1.3a12.7 12.7 0 0 1 6.7 0C19 4.3 20 4.6 20 4.6c.7 1.8.3 3.1.2 3.4a4.7 4.7 0 0 1 1.2 3.2c0 4.7-2.8 5.7-5.5 6 .4.4.8 1.1.8 2.2v3.1c0 .3.2.6.8.5A11.4 11.4 0 0 0 12 .8Z"/></svg>
            <span class="hidden sm:inline">GitHub</span>
        </a>
    </nav>
</header>
