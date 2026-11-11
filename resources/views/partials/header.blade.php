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
            menuAnim: false,
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
        x-effect="document.documentElement.classList.toggle('overflow-hidden', menuOpen);
                  if (menuOpen) requestAnimationFrame(() => requestAnimationFrame(() => menuAnim = true)); else menuAnim = false"
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
                Randevu Al
            </button>

            {{-- Mobil menü düğmesi --}}
            <button type="button" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen" aria-controls="mobile-menu"
                    :aria-label="menuOpen ? 'Menüyü kapat' : 'Menüyü aç'"
                    :class="menuOpen ? 'bg-brand-900 text-white ring-brand-900' : 'bg-brand-50 text-brand-700 ring-brand-100 hover:bg-brand-100'"
                    class="flex h-11 w-11 cursor-pointer items-center justify-center rounded-full ring-1 transition-colors duration-300 xl:hidden">
                {{-- üç çizgi → çarpı --}}
                <span aria-hidden="true" class="relative block h-3.5 w-[18px]">
                    <span class="absolute left-0 h-[1.75px] w-full rounded-full bg-current transition-all duration-300 ease-[cubic-bezier(.2,.7,.2,1)]"
                          :class="menuOpen ? 'top-1/2 -translate-y-1/2 rotate-45' : 'top-0'"></span>
                    <span class="absolute top-1/2 left-0 h-[1.75px] -translate-y-1/2 rounded-full bg-current transition-all duration-300"
                          :class="menuOpen ? 'w-0 opacity-0' : 'w-3/4 opacity-100'"></span>
                    <span class="absolute left-0 h-[1.75px] w-full rounded-full bg-current transition-all duration-300 ease-[cubic-bezier(.2,.7,.2,1)]"
                          :class="menuOpen ? 'top-1/2 -translate-y-1/2 -rotate-45' : 'top-[calc(100%-1.75px)]'"></span>
                </span>
            </button>
        </div>
    </div>

    {{-- Mobil menü: koyu yeşil perde yukarıdan açılır, bağlantılar sırayla kayarak gelir --}}
    @php($ist = config('brand.branches.istanbul'))
    <div id="mobile-menu" x-cloak x-show="menuOpen" :data-open="menuAnim" role="dialog" aria-modal="true" aria-label="Menü"
         x-transition:enter="transition-[clip-path,opacity] duration-500 ease-[cubic-bezier(.2,.7,.2,1)]"
         x-transition:enter-start="opacity-60 [clip-path:inset(0_0_100%_0)]" x-transition:enter-end="opacity-100 [clip-path:inset(0_0_0_0)]"
         x-transition:leave="transition-[clip-path,opacity] duration-300 ease-in"
         x-transition:leave-start="opacity-100 [clip-path:inset(0_0_0_0)]" x-transition:leave-end="opacity-60 [clip-path:inset(0_0_100%_0)]"
         class="mobile-menu absolute inset-x-0 top-full isolate h-[calc(100dvh-4rem)] overflow-y-auto overscroll-contain bg-brand-950 text-white lg:h-[calc(100dvh-76px)] xl:hidden">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(70%_55%_at_100%_0%,rgba(13,111,74,.45),transparent_70%),radial-gradient(60%_45%_at_0%_100%,rgba(201,151,63,.12),transparent_70%)]"></div>
        <x-logo-mark class="pointer-events-none absolute -right-16 bottom-24 -z-10 h-[340px] w-auto select-none" style="--logo-ink:#ffffff; --logo-accent:#ffffff; opacity:.04" />

        <div class="mx-auto flex min-h-full max-w-xl flex-col px-6 pt-7 pb-8">
            <p class="mm-item flex items-center gap-3 text-[11px] font-medium uppercase tracking-[0.32em] text-[#e2b979]" style="--i:0"><span class="h-px w-8 bg-[#c9973f]"></span>Menü</p>

            <nav class="mt-4" aria-label="Mobil menü">
                @foreach($nav as $id => $label)
                    @php($isStories = $id === 'hasta-hikayeleri')
                    <a href="{{ $isStories ? route('stories.index') : $anchor($id) }}" @click="menuOpen = false" @if($label === 'Invisalign') lang="en" @endif
                       style="--i: {{ $loop->iteration }}"
                       class="mm-item group flex items-center gap-4 border-b border-white/10 py-[15px] transition-colors hover:text-[#e2b979] {{ $isStories && request()->routeIs('stories.*') ? 'text-[#e2b979]' : 'text-white' }}">
                        <span class="w-6 font-mono text-[11px] text-[#c9973f]/80">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="flex-1 text-[24px] font-light tracking-[-0.01em]">{{ $label }}</span>
                        <i class="fa-solid fa-arrow-right -translate-x-1 text-[13px] text-white/30 transition group-hover:translate-x-0 group-hover:text-[#e2b979]"></i>
                    </a>
                @endforeach
            </nav>

            <div class="mm-item mt-auto pt-8" style="--i: {{ count($nav) + 1 }}">
                <button type="button" @click="menuOpen = false; Livewire.dispatch('open-book-consultation')"
                        class="flex h-14 w-full cursor-pointer items-center justify-center gap-2.5 rounded-2xl bg-white text-[15px] font-semibold text-brand-900 shadow-[0_18px_40px_-20px_rgba(0,0,0,.6)] transition hover:bg-brand-50">
                    <i class="fa-regular fa-calendar-check text-[16px] text-brand-700"></i> Randevu Al
                </button>
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <a href="tel:{{ $phoneLink }}" class="flex h-12 items-center justify-center gap-2 rounded-2xl text-[14px] font-medium text-white ring-1 ring-white/20 transition hover:bg-white/5">
                        <i class="fa-solid fa-phone text-[13px] text-[#e2b979]"></i> Ara
                    </a>
                    <a href="{{ $whatsappUrl ?? \App\Support\WhatsApp::url() }}" target="_blank" rel="noopener" class="flex h-12 items-center justify-center gap-2 rounded-2xl bg-[#25D366] text-[14px] font-medium text-white transition hover:bg-[#1faa55]">
                        <i class="fa-brands fa-whatsapp text-[17px]"></i> WhatsApp
                    </a>
                </div>
                @if($ist)
                    <div class="mt-6 space-y-2 text-[13px] text-white/55">
                        <p class="flex gap-2.5"><i class="fa-solid fa-location-dot mt-[3px] w-3.5 text-[12px] text-[#c9973f]"></i>{{ $ist['address'] }}</p>
                        @foreach($ist['hours'] as $day => $time)
                            <p class="flex gap-2.5"><i class="fa-regular fa-clock mt-[3px] w-3.5 text-[12px] text-[#c9973f]"></i>{{ $day }} · {{ $time }}</p>
                            @break
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</header>
