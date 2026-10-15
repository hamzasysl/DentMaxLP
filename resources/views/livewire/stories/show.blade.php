{{-- Hasta hikayesi detay: üst bilgi + önce/sonra, süreç zaman çizelgesi, hasta & hekim notu, galeri, randevu bandı, sonraki hikaye --}}
@php
    $doctor = config('brand.doctor');
    $stats = array_filter([
        ['Yaş', $story['age'] ?? null],
        ['Tedavi süresi', $story['duration'] ?? null],
        ['Plak sayısı', !empty($story['aligners']) ? $story['aligners'] . ' adet' : null],
        ['Muayene yeri', $story['location'] ?? null],
    ], fn ($s) => $s[1]);
    $iconMask = fn ($key) => "-webkit-mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat; mask: url('" . asset('img/invisalign/bite/' . $key . '.svg') . "') center / contain no-repeat;";
@endphp

<div>
    {{-- ============ ÜST: kimlik + önce/sonra ============ --}}
    <section class="relative isolate overflow-clip bg-ivory pt-28 pb-14 lg:pt-36 lg:pb-20">
        <x-mark-watermark class="-right-28 top-24 h-[460px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">

            <nav aria-label="Konum" class="flex items-center gap-2 text-[12.5px] text-main-400">
                <a href="{{ route('home') }}" class="transition hover:text-brand-700">Ana sayfa</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <a href="{{ route('stories.index') }}" class="transition hover:text-brand-700">Hasta hikayeleri</a>
                <i class="fa-solid fa-chevron-right text-[8px]"></i>
                <span class="text-main-600">{{ $story['name'] }}</span>
            </nav>

            <div class="mt-8 grid items-center gap-10 lg:mt-10 lg:grid-cols-[1fr_1.1fr] lg:gap-16">
                <div data-reveal>
                    <div class="flex flex-wrap items-center gap-2.5">
                        <span class="inline-flex items-center gap-2.5 rounded-full bg-white py-1.5 pr-4 pl-1.5 text-[12.5px] text-brand-800 ring-1 ring-main-200/80">
                            <span class="inline-flex h-7 w-11 items-center justify-center rounded-full bg-brand-50">
                                <span aria-hidden="true" class="block h-3.5 w-8 bg-current text-brand-700" style="{{ $iconMask($story['condition']) }}"></span>
                            </span>
                            {{ $story['condition_label'] }}
                        </span>
                        @if(!empty($story['example']))
                            <span class="rounded-full bg-[#c9973f]/10 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.16em] text-[#8a5f22] ring-1 ring-[#c9973f]/30">Örnek içerik</span>
                        @endif
                    </div>

                    <p class="mt-6 flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-600"><span class="h-px w-8 bg-[#c9973f]"></span>Hasta hikayesi</p>
                    <h1 class="mt-3 text-[clamp(34px,4.2vw,56px)] leading-[1.08] tracking-[-0.025em] text-brand-900">
                        <span class="font-light">{{ $story['name'] }}</span>
                        <span class="block font-semibold"><span lang="en">Invisalign</span> ile {{ $story['duration'] }}</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-[16.5px] leading-relaxed text-main-600">{{ $story['summary'] }}</p>

                    <dl class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
                        @foreach($stats as [$label, $value])
                            <div class="rounded-2xl bg-white px-4 py-3.5 ring-1 ring-main-200/70">
                                <dt class="text-[11px] uppercase tracking-[0.16em] text-main-400">{{ $label }}</dt>
                                <dd class="mt-1 text-[17px] font-medium text-brand-900">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div data-reveal style="--d:120ms">
                    <x-before-after :before="$story['photos']['before'] ?? null" :after="$story['photos']['after'] ?? null"
                                    :alt="$story['name'] . ' – ' . $story['condition_label']"
                                    class="shadow-[0_40px_80px_-50px_rgba(38,28,22,.55)] ring-1 ring-main-200/70" />
                    @if(!empty($story['finished']))
                        <p class="mt-3 text-right text-[12.5px] text-main-400">Tedavi tamamlandı: {{ $story['finished'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============ SÜREÇ + NOTLAR ============ --}}
    <section class="relative isolate overflow-clip bg-white py-16 lg:py-24">
        <div class="mx-auto grid max-w-site gap-12 px-5 lg:grid-cols-[1.15fr_1fr] lg:gap-16 lg:px-8">

            {{-- Zaman çizelgesi --}}
            <div>
                <p data-reveal class="eyebrow flex items-center gap-4"><span class="h-px w-10 bg-brand-600"></span>Tedavi süreci</p>
                <h2 data-reveal class="mt-5 text-[clamp(28px,3vw,40px)] leading-[1.12] tracking-[-0.02em] text-main-900">
                    <span class="font-thin">Adım Adım</span> <span class="font-light">Neler Yaşandı?</span>
                </h2>

                <ol class="relative mt-10 space-y-7 before:absolute before:top-2 before:bottom-2 before:left-[19px] before:w-px before:bg-gradient-to-b before:from-brand-300 before:via-brand-200 before:to-[#c9973f]/60">
                    @foreach($story['timeline'] as $i => $step)
                        <li data-reveal style="--d: {{ $i * 80 }}ms" class="relative flex gap-5">
                            <span class="relative z-10 inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full font-mono text-[12px] {{ $loop->last ? 'bg-brand-900 text-white' : 'bg-white text-brand-700 ring-1 ring-brand-200' }}">
                                @if($loop->last)<i class="fa-solid fa-check text-[12px]"></i>@else{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}@endif
                            </span>
                            <div class="flex-1 rounded-2xl bg-ivory px-5 py-4 ring-1 ring-main-200/60">
                                <p class="text-[11.5px] font-semibold uppercase tracking-[0.18em] text-[#b07d34]">{{ $step['when'] }}</p>
                                <h3 class="mt-1 text-[17px] font-normal text-main-900">{{ $step['title'] }}</h3>
                                <p class="mt-1.5 text-[14.5px] leading-relaxed text-main-500">{{ $step['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            {{-- Hasta ve hekim notu --}}
            <div class="space-y-5 lg:pt-16">
                @if(!empty($story['quote']))
                    <figure data-reveal class="relative overflow-hidden rounded-[24px] bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 p-7 text-white sm:p-8">
                        <i aria-hidden="true" class="fa-solid fa-quote-left absolute top-5 right-6 text-[56px] text-white/10"></i>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#e2b979]">Hastamızın anlatımıyla</p>
                        <blockquote class="mt-4 text-[18px] leading-relaxed font-light">“{{ $story['quote'] }}”</blockquote>
                        <figcaption class="mt-5 flex items-center gap-3 text-[13.5px] text-white/70">
                            <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-white/15 text-[12px] font-medium text-white">{{ \Illuminate\Support\Str::of($story['name'])->replace(['.', ' '], '')->substr(0, 2) }}</span>
                            {{ $story['name'] }} · {{ $story['age'] }} yaş
                        </figcaption>
                    </figure>
                @endif

                @if(!empty($story['doctor_note']))
                    <figure data-reveal style="--d:100ms" class="rounded-[24px] bg-ivory p-7 ring-1 ring-main-200/70 sm:p-8">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-brand-600">Hekim değerlendirmesi</p>
                        <blockquote class="mt-4 text-[16px] leading-relaxed text-main-700">{{ $story['doctor_note'] }}</blockquote>
                        <figcaption class="mt-5 flex items-center gap-3">
                            <img src="{{ asset('img/lp/invisalign/dr-fatih-kahraman.webp') }}" alt="{{ $doctor['name'] }}" loading="lazy"
                                 class="h-11 w-11 rounded-full bg-white object-cover object-top ring-1 ring-main-200">
                            <span class="leading-tight">
                                <span class="block text-[14.5px] font-medium text-main-900">{{ $doctor['name'] }}</span>
                                <span class="block text-[12.5px] text-main-500">Ortodonti Uzmanı</span>
                            </span>
                        </figcaption>
                    </figure>
                @endif
            </div>
        </div>
    </section>

    {{-- ============ GALERİ (varsa) ============ --}}
    @if(!empty($story['photos']['gallery']))
        <section class="bg-ivory py-14 lg:py-20">
            <div class="mx-auto max-w-site px-5 lg:px-8">
                <p class="eyebrow flex items-center gap-4"><span class="h-px w-10 bg-brand-600"></span>Süreçten kareler</p>
                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                    @foreach($story['photos']['gallery'] as $img)
                        <img src="{{ asset($img) }}" alt="{{ $story['name'] }} tedavi süreci {{ $loop->iteration }}" loading="lazy"
                             class="aspect-square w-full rounded-2xl object-cover ring-1 ring-main-200/70">
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============ SONRAKİ HİKAYE ============ --}}
    <section class="bg-white py-12 lg:py-16">
        <div class="mx-auto flex max-w-site flex-col gap-4 px-5 sm:flex-row sm:items-center sm:justify-between lg:px-8">
            <a href="{{ route('stories.index') }}" class="inline-flex items-center gap-2 text-[14px] text-main-600 transition hover:text-brand-700">
                <i class="fa-solid fa-arrow-left text-[11px]"></i> Tüm hasta hikayeleri
            </a>
            @if($next)
                <a href="{{ route('stories.show', $next['slug']) }}" class="group flex items-center gap-4 rounded-2xl bg-ivory py-3 pr-5 pl-3 ring-1 ring-main-200/70 transition hover:ring-brand-300">
                    <span class="inline-flex h-12 w-16 items-center justify-center rounded-xl bg-white ring-1 ring-main-200/70">
                        <span aria-hidden="true" class="block h-5 w-12 bg-current text-brand-700" style="{{ $iconMask($next['condition']) }}"></span>
                    </span>
                    <span class="leading-tight">
                        <span class="block text-[11px] uppercase tracking-[0.18em] text-main-400">Sonraki hikaye</span>
                        <span class="mt-1 block text-[15px] font-medium text-main-900">{{ $next['name'] }} · {{ $next['condition_label'] }}</span>
                    </span>
                    <i class="fa-solid fa-arrow-right ml-2 text-[12px] text-brand-600 transition group-hover:translate-x-0.5"></i>
                </a>
            @endif
        </div>
    </section>
</div>
