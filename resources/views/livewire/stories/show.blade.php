{{-- Hasta hikayesi detay: üst bilgi + önce/sonra, süreç zaman çizelgesi, hasta & hekim notu, galeri, randevu bandı, sonraki hikaye --}}
@php
    $doctor = config('brand.doctor');
    $stats = array_filter([
        ['Yaş', empty($story['photos']['portrait']) ? ($story['age'] ?? null) : null],
        ['Tedavi süresi', $story['duration'] ?? null],
        ['Plan', !empty($story['stages']) ? $story['stages'] . ' aşama' : null],
        ['Başlangıç', $story['started'] ?? null],
        ['Plak sayısı', !empty($story['aligners']) ? $story['aligners'] . ' adet' : null],
        ['Şehir', $story['location'] ?? null],
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
                    @if(!empty($story['photos']['portrait']))
                        <div class="flex items-center gap-4">
                            <img src="{{ asset($story['photos']['portrait']) }}" alt="{{ $story['name'] }}" width="84" height="84"
                                 class="h-[84px] w-[84px] shrink-0 rounded-full bg-white object-cover ring-[3px] ring-white shadow-[0_16px_30px_-16px_rgba(0,38,23,.55)]">
                            <div class="min-w-0">
                                <p class="text-[19px] font-medium leading-tight text-brand-900">{{ $story['name'] }}</p>
                                <p class="mt-1 text-[14px] text-main-500">{{ $story['age'] }} yaş · {{ $story['condition_label'] }}</p>
                            </div>
                        </div>
                    @else
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
                    @endif

                    <p class="mt-7 flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-600"><span class="h-px w-8 bg-[#c9973f]"></span>Hasta hikayesi</p>
                    <h1 class="mt-3 text-[clamp(36px,4.4vw,60px)] leading-[1.06] tracking-[-0.025em] text-brand-900">
                        <span class="block font-light">{{ $story['title'][0] ?? $story['name'] }}</span>
                        <span class="block font-semibold">{{ $story['title'][1] ?? 'Invisalign ile ' . $story['duration'] }}</span>
                    </h1>
                    <p class="mt-5 max-w-xl text-[16.5px] leading-relaxed text-main-600">{{ $story['summary'] }}</p>

                    <dl class="mt-8 grid gap-3 {{ count($stats) === 3 ? 'grid-cols-3' : 'grid-cols-2 sm:grid-cols-4' }}">
                        @foreach($stats as [$label, $value])
                            <div class="rounded-2xl bg-white px-3 py-3 ring-1 ring-main-200/70 sm:px-4 sm:py-3.5">
                                <dt class="text-[10.5px] uppercase tracking-[0.12em] text-main-400 sm:text-[11px] sm:tracking-[0.16em]">{{ $label }}</dt>
                                <dd class="mt-1 text-[14.5px] font-medium whitespace-nowrap text-brand-900 sm:text-[17px]">{{ $value }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div data-reveal style="--d:120ms">
                    @if(!empty($story['video']))
                        <figure>
                            <video class="aspect-video w-full rounded-[24px] bg-[#6e6e6e] object-cover shadow-[0_40px_80px_-50px_rgba(0,38,23,.55)] ring-1 ring-main-200/70"
                                   autoplay muted loop playsinline preload="metadata" poster="{{ asset($story['video']['poster']) }}"
                                   aria-label="Tedavi planı simülasyonu">
                                <source src="{{ asset($story['video']['src']) . '?v=' . @filemtime(public_path($story['video']['src'])) }}" type="video/mp4">
                            </video>
                            <figcaption class="mt-3 text-[12.5px] leading-relaxed text-main-400">ClinCheck® tedavi planı simülasyonudur. Tedavi sonuçları kişiye göre değişebilir; gerçek tedavi planını hekiminiz belirler.</figcaption>
                        </figure>
                    @else
                        <x-before-after :before="$story['photos']['before'] ?? null" :after="$story['photos']['after'] ?? null"
                                        :alt="$story['name'] . ' – ' . $story['condition_label']"
                                        class="shadow-[0_40px_80px_-50px_rgba(0,38,23,.55)] ring-1 ring-main-200/70" />
                    @endif
                    @if(!empty($story['finished']))
                        <p class="mt-3 text-right text-[12.5px] text-main-400">Tedavi tamamlandı: {{ $story['finished'] }}</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- ============ 3D PLAN ============ --}}
    @if(!empty($story['model']))
        <section class="relative isolate overflow-hidden bg-brand-950 py-16 text-white lg:py-24">
            <div aria-hidden="true" class="absolute inset-0 -z-10 bg-[radial-gradient(55%_70%_at_50%_45%,rgba(13,111,74,.35),transparent_70%)]"></div>
            <div class="mx-auto max-w-site px-5 lg:px-8">
                <div data-reveal class="mx-auto max-w-2xl text-center">
                    <p class="flex items-center justify-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-200"><span class="h-px w-8 bg-[#c9973f]"></span>3D tedavi planı</p>
                    <h2 class="mt-4 text-[clamp(28px,3.2vw,44px)] leading-[1.12] tracking-[-0.02em]"><span class="font-thin">Dişlerin</span> <span class="font-light">Planlanan Hareketi</span></h2>
                    <p class="mt-4 text-[15.5px] leading-relaxed text-white/65">Kaydırıcıyı çekerek dişlerin başlangıçtan plan sonuna nasıl hareket ettiğini izleyin. Modeli parmağınızla ya da farenizle döndürebilirsiniz.</p>
                </div>

                <div data-case-viewer data-src="{{ asset($story['model']) . '?v=' . @filemtime(public_path($story['model'])) }}" data-start="a" class="case-viewer mx-auto mt-8 max-w-4xl">
                    <div class="relative">
                        <div data-stage class="aspect-[4/3] w-full cursor-grab active:cursor-grabbing sm:aspect-[16/9]"></div>
                        <p class="case-viewer-wait pointer-events-none absolute inset-0 flex items-center justify-center text-[13.5px] text-white/50">3D model yükleniyor…</p>
                    </div>

                    <div class="mx-auto max-w-xl">
                        <div class="flex items-center gap-4">
                            <button type="button" data-go="0" class="cursor-pointer text-[13px] text-white/70 transition hover:text-white">Başlangıç</button>
                            <input data-progress type="range" min="0" max="1000" value="0" aria-label="Tedavi planı ilerlemesi" class="case-range min-w-0 flex-1">
                            <button type="button" data-go="1" class="cursor-pointer text-[13px] text-[#e2b979] transition hover:text-white">Plan sonu</button>
                        </div>
                        <div class="mt-5 flex justify-center gap-2" role="group" aria-label="Çene seçimi">
                            @foreach(['both' => 'İki çene', 'U' => 'Üst çene', 'L' => 'Alt çene'] as $key => $label)
                                <button type="button" data-jaw="{{ $key }}" class="cursor-pointer rounded-full px-4 py-2 text-[13px] text-white/70 ring-1 ring-white/15 transition hover:text-white aria-pressed:bg-white aria-pressed:font-medium aria-pressed:text-brand-900">{{ $label }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <p class="mx-auto mt-6 max-w-2xl text-center text-[12.5px] leading-relaxed text-white/45">Bu model hastanın dijital tedavi planından üretilmiş bir simülasyondur. Tedavi sonuçları kişiye göre değişebilir.</p>
            </div>
        </section>
    @endif

    {{-- ============ SÜREÇ + NOTLAR ============ --}}
    <section class="relative isolate overflow-clip bg-white py-16 lg:py-24">
        @php($hasSide = !empty($story['plan']) || !empty($story['quote']) || !empty($story['doctor_note']))
        <div class="mx-auto grid gap-12 px-5 lg:gap-16 lg:px-8 {{ $hasSide ? 'max-w-site lg:grid-cols-[1.15fr_1fr]' : 'max-w-3xl' }}">

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

            {{-- Tedavi planı, hasta ve hekim notu --}}
            @if($hasSide)
            <div class="space-y-5 lg:pt-16">
                @if(!empty($story['plan']))
                    <div data-reveal class="rounded-[24px] bg-gradient-to-br from-brand-900 via-brand-800 to-brand-700 p-7 text-white sm:p-8">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#e2b979]">Tedavi planı</p>
                        <ul class="mt-5 space-y-5">
                            @foreach($story['plan'] as $item)
                                <li class="flex gap-3.5">
                                    <span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-white/10 text-[10px] text-[#e2b979] ring-1 ring-white/15"><i class="fa-solid fa-check"></i></span>
                                    <span>
                                        <span class="block text-[16px] font-normal">{{ $item['title'] }}</span>
                                        <span class="mt-1 block text-[14px] leading-relaxed text-white/70">{{ $item['text'] }}</span>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
            @endif
        </div>
    </section>

    {{-- ============ GALERİ (varsa) ============ --}}
    @if(!empty($story['photos']['gallery']) || !empty($story['photos']['xray']))
        <section class="bg-ivory py-14 lg:py-20">
            <div class="mx-auto max-w-site px-5 lg:px-8">
                <p class="eyebrow flex items-center gap-4"><span class="h-px w-10 bg-brand-600"></span>Klinik kayıtlar</p>
                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                    @if(!empty($story['photos']['xray']))
                        <figure class="col-span-2 lg:row-span-2">
                            <img src="{{ asset($story['photos']['xray']) }}" alt="Panoramik diş röntgeni" loading="lazy"
                                 class="aspect-[2/1] w-full rounded-2xl bg-black object-contain ring-1 ring-main-200/70 lg:aspect-auto lg:h-[calc(100%-1.75rem)]">
                            <figcaption class="mt-2 text-[12.5px] text-main-500">Panoramik röntgen</figcaption>
                        </figure>
                    @endif
                    @foreach($story['photos']['gallery'] ?? [] as $img)
                        @php($item = is_array($img) ? $img : ['src' => $img, 'label' => null])
                        <figure>
                            <img src="{{ asset($item['src']) }}" alt="{{ $item['label'] ?? $story['name'] . ' tedavi süreci ' . $loop->iteration }}" loading="lazy"
                                 class="aspect-square w-full rounded-2xl object-cover ring-1 ring-main-200/70">
                            @if($item['label'])<figcaption class="mt-2 text-[12.5px] text-main-500">{{ $item['label'] }}</figcaption>@endif
                        </figure>
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
