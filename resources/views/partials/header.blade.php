@php
    $homeUrl  = url('/');
    $isBase   = request()->is('/') || request()->routeIs('home');
    $anchor   = fn (string $id) => $isBase ? "#{$id}" : "{$homeUrl}#{$id}";

    $nav = [
        'vakalar'          => 'Invisalign',
        'tedavi-sureci'    => 'Tedavi Süreci',
        'hasta-hikayeleri' => 'Hasta Hikayeleri', // ayrı sayfa (stories.index)
        'hekim'            => 'Hakkımda',
        'yorumlar'         => 'Yorumlar',
        'sss'              => 'SSS',
    ];
@endphp

<header x-data="{
            scrolled: false,
            active: '',
            menuOpen: false,
            spy() {
                const ids = @js(array_values(array_diff(array_keys($nav), ['hasta-hikayeleri'])));
                const io = new IntersectionObserver((entries) => {
                    entries.forEach(e => { if (e.isIntersecting) this.active = e.target.id; });
                }, { rootMargin: '-40% 0px -55% 0px' });
                ids.forEach(id => { const el = document.getElementById(id); if (el) io.observe(el); });
                // Sayfanın en üstünde hiçbir başlık seçili olmasın
                window.addEventListener('scroll', () => { if (window.scrollY < 200) this.active = ''; }, { passive: true });
            },
        }"
        x-init="scrolled = window.scrollY > 8; spy()"
        @scroll.window="scrolled = window.scrollY > 8"
        @click.outside="menuOpen = false"
        @keydown.escape.window="menuOpen = false"
        :class="scrolled ? 'border-main-100 bg-white/95 shadow-[0_8px_30px_-12px_rgba(0,38,23,.25)]' : 'border-transparent'"
        class="fixed inset-x-0 top-0 z-50 border-b bg-white/90 backdrop-blur-md transition-[box-shadow,border-color,background-color] duration-300">
    <div class="mx-auto flex h-16 max-w-site items-center justify-between gap-4 px-5 lg:h-[76px] lg:px-8">

        {{-- Logo --}}
        <a href="{{ $homeUrl }}" class="flex shrink-0 items-center" aria-label="{{ config('brand.name') }}">
            <x-logo class="text-[16px] sm:text-[17px] lg:text-[19px]" />
        </a>

        {{-- Masaüstü menü --}}
        <nav class="hidden items-center gap-7 text-[12px] font-normal uppercase tracking-[0.16em] text-main-700 xl:flex" aria-label="Sayfa içi">
            @foreach($nav as $id => $label)
                @php($isStories = $id === 'hasta-hikayeleri')
                <a href="{{ $isStories ? route('stories.index') : $anchor($id) }}" @if($label === 'Invisalign') lang="en" @endif
                   @unless($isStories) :class="active === '{{ $id }}' ? 'text-brand-700 after:scale-x-100' : ''" @endunless
                   class="relative py-2 transition hover:text-brand-700 after:absolute after:inset-x-0 after:-bottom-0.5 after:h-0.5 after:origin-left after:scale-x-0 after:rounded-full after:bg-gradient-to-r after:from-brand-700 after:to-[#c9973f] after:transition-transform hover:after:scale-x-100 {{ $isStories && request()->routeIs('stories.*') ? 'text-brand-700 after:scale-x-100' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </nav>

        {{-- Sağ: telefon + WhatsApp + CTA --}}
        <div class="flex items-center gap-2 sm:gap-2.5">
            <a href="tel:{{ $phoneLink }}" aria-label="Bizi arayın: {{ $phoneText }}" title="{{ $phoneText }}"
               class="hidden h-10 w-10 items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100 transition hover:bg-brand-100 hover:ring-brand-200 sm:flex">
                <i class="fa-solid fa-phone text-[14px]"></i>
            </a>
            <a href="{{ $whatsappUrl ?? \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener" aria-label="WhatsApp ile yazın" title="WhatsApp"
               class="hidden h-10 w-10 items-center justify-center rounded-full bg-[#25D366]/10 text-[#1faa55] ring-1 ring-[#25D366]/25 transition hover:bg-[#25D366]/15 hover:ring-[#25D366]/45 sm:flex">
                <i class="fa-brands fa-whatsapp text-[19px]"></i>
            </a>

            {{-- CTA: Rolex yeşili gradyan (lg altında alttaki sabit bar gösterir) --}}
            <button type="button" onclick="Livewire.dispatch('open-book-consultation')"
                    class="btn-accent relative hidden h-10 cursor-pointer items-center gap-2 overflow-hidden rounded-full px-4 text-[12.5px] font-semibold whitespace-nowrap shadow-[0_12px_26px_-10px_rgba(0,38,23,.75)] ring-2 ring-brand-100/80 transition hover:-translate-y-px sm:ml-1 sm:h-11 sm:px-6 sm:text-[14px] sm:ring-4 lg:inline-flex">
                <i class="fa-regular fa-calendar-check hidden text-[14px] text-[#ecd3a2] sm:inline"></i>
                Yerinizi Ayırtın
            </button>

            {{-- Mobil menü düğmesi --}}
            <button type="button" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen" aria-controls="mobile-menu"
                    :aria-label="menuOpen ? 'Menüyü kapat' : 'Menüyü aç'"
                    class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full bg-brand-50 text-brand-700 ring-1 ring-brand-100 transition hover:bg-brand-100 xl:hidden">
                <i class="fa-solid fa-bars text-[18px]" :class="menuOpen ? 'fa-xmark' : 'fa-bars'"></i>
            </button>
        </div>
    </div>

    {{-- Mobil menü --}}
    <nav id="mobile-menu" x-cloak x-show="menuOpen" aria-label="Mobil menü"
         x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="max-h-[calc(100dvh-4rem)] overflow-y-auto border-t border-main-100 bg-white px-5 py-2 xl:hidden">
        @foreach($nav as $id => $label)
            @php($isStories = $id === 'hasta-hikayeleri')
            <a href="{{ $isStories ? route('stories.index') : $anchor($id) }}" @click="menuOpen = false" @if($label === 'Invisalign') lang="en" @endif
               class="flex items-center justify-between border-b border-main-100 py-3.5 text-[15px] transition last:border-b-0 hover:text-brand-700 {{ $isStories && request()->routeIs('stories.*') ? 'text-brand-700' : 'text-main-800' }}">
                {{ $label }}
                <i class="fa-solid fa-chevron-right text-[11px] text-main-300"></i>
            </a>
        @endforeach
    </nav>
</header>
