<footer class="border-t border-slate-200 bg-[#fffaf8]">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 px-5 py-8 text-sm text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-8">
        <div class="flex items-center gap-3">
            <img src="{{ asset('brand/world-logo.jpg') }}" alt="" class="size-8 rounded-lg border border-slate-200 bg-white object-cover">
            <p>World is open source software licensed under the MIT license.</p>
        </div>
        <div class="flex flex-wrap gap-5">
            <a href="{{ config('world_ui.documentation_url') }}" target="_blank" rel="noreferrer" class="transition hover:text-[#f45143]">2.0 documentation</a>
            <a href="{{ config('world_ui.legacy_documentation_url') }}" target="_blank" rel="noreferrer" class="transition hover:text-[#f45143]">1.x documentation</a>
            <a href="https://github.com/nnjeim/world" target="_blank" rel="noreferrer" class="transition hover:text-[#f45143]">GitHub</a>
            <a href="https://packagist.org/packages/nnjeim/world" target="_blank" rel="noreferrer" class="transition hover:text-[#f45143]">Packagist</a>
            <a href="https://github.com/nnjeim/world/releases" target="_blank" rel="noreferrer" class="transition hover:text-[#f45143]">Releases</a>
        </div>
    </div>
</footer>
