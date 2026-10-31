{{-- Invisalign LP (TR) — Atom/HD Smile tarzı: açık, kompakt, tek vurgu rengi --}}
@php
    $doctor   = config('brand.doctor');
    $initials = 'FK';
    $btnAccent  = 'btn-accent inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-[12.5px] font-semibold uppercase tracking-[0.16em]';
    $btnDark  = 'btn-accent inline-flex cursor-pointer items-center justify-center gap-2 rounded-xl px-6 py-3.5 text-[12.5px] font-semibold uppercase tracking-[0.16em]';
    $btnGhostLight = 'inline-flex items-center justify-center gap-2 rounded-xl border border-main-200 bg-white px-6 py-3.5 text-[12.5px] font-semibold uppercase tracking-[0.16em] text-main-900 transition hover:border-brand-400 hover:text-brand-700';
    $btnGlass = 'glass inline-flex items-center justify-center gap-2 rounded-full px-6 py-3.5 text-[15px] font-semibold text-white transition hover:bg-white/10';
@endphp
<div>

    {{-- ============ 1. HERO (premium: video + vurgu perdesi + form) ============ --}}
    <section class="relative isolate overflow-hidden bg-main-900 pt-28 pb-16 lg:pt-32 lg:pb-20">
        <video class="absolute inset-0 -z-30 h-full w-full object-cover motion-reduce:hidden"
               autoplay muted loop playsinline preload="metadata" aria-hidden="true"
               poster="{{ asset('img/hero-poster.jpg') }}">
            <source src="{{ asset('videos/hero.webm') }}" type="video/webm">
            <source src="{{ asset('videos/hero.mp4') }}" type="video/mp4">
        </video>
        <img src="{{ asset('img/hero-poster.jpg') }}" alt="" aria-hidden="true" class="absolute inset-0 -z-30 hidden h-full w-full object-cover motion-reduce:block">

        {{-- Perde: soldan vurgu rengi, sağa doğru açılır --}}
        <div aria-hidden="true" class="absolute inset-0 -z-20 bg-[linear-gradient(90deg,rgb(0_61_36/.9)_0%,rgb(0_79_47/.78)_40%,rgb(0_38_23/.45)_78%,rgb(0_38_23/.32)_100%)]"></div>
        {{-- Sinematik derinlik: üst/alt kararma --}}
        <div aria-hidden="true" class="absolute inset-0 -z-20 bg-[linear-gradient(180deg,rgb(0_30_18/.35)_0%,transparent_28%,transparent_72%,rgb(0_30_18/.4)_100%)]"></div>
        {{-- Soldan şeritler --}}
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 -left-32 -z-10 w-[44%] -skew-x-12 bg-white/[0.035]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-[34%] -z-10 hidden w-px -skew-x-12 bg-gradient-to-b from-transparent via-white/25 to-transparent lg:block"></div>
        <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-[36.5%] -z-10 hidden w-px -skew-x-12 bg-gradient-to-b from-transparent via-brand-300/30 to-transparent lg:block"></div>

        <div class="mx-auto grid max-w-site items-center gap-12 px-5 lg:grid-cols-[1.08fr_.92fr] lg:gap-14 lg:px-8">
            <div class="text-white">
                <p data-reveal class="flex items-center gap-3 text-[10.5px] font-medium uppercase tracking-[0.22em] text-white/70 sm:gap-4 sm:text-[11px] sm:tracking-[0.32em]">
                    <span class="h-px w-8 shrink-0 bg-brand-300/70 sm:w-10"></span>
                    <span><span lang="en">Invisalign®</span> · İstanbul · Bakırköy</span>
                </p>

                <h1 data-reveal style="--d:80ms" class="mt-6 text-[38px] font-normal leading-[1.08] tracking-[-0.025em] sm:text-[50px] lg:text-[58px]">
                    Tel Takmadan,<br>
                    Kusursuz Dişler.
                </h1>

                <p data-reveal style="--d:160ms" class="mt-6 max-w-[34rem] text-[16px] leading-[1.75] text-white/70">
                    Dişleriniz 3D taramayla planlanır, size özel şeffaf plaklarla tel takmadan düzelir.
                </p>


                <div data-reveal style="--d:280ms" class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2.5 rounded-xl bg-white px-6 py-3.5 text-[12px] font-semibold uppercase tracking-[0.16em] text-main-900 shadow-[0_14px_30px_-14px_rgba(0,0,0,.5)] transition hover:bg-main-100">
                        <i class="fa-brands fa-whatsapp text-[16px] text-[#25D366]"></i> WhatsApp danışma
                    </a>
                    <a href="tel:{{ $phoneLink }}" class="inline-flex items-center gap-2.5 rounded-xl border border-white/25 px-6 py-3.5 text-[12px] font-semibold uppercase tracking-[0.16em] text-white transition hover:border-white/50 hover:bg-white/5">
                        <i class="fa-solid fa-phone text-[12px]"></i> {{ $phoneText }}
                    </a>
                </div>

                <dl data-reveal style="--d:340ms" class="mt-10 hidden max-w-lg grid-cols-3 gap-6 border-t border-white/10 pt-6 sm:grid">
                    @foreach([['6–18', 'ay', 'Ortalama süre'], ['3D', '', 'Dijital planlama'], ['Kişiye', '', 'Özel randevu']] as [$v, $u, $l])
                        <div>
                            <dt class="text-[30px] font-extralight leading-none tracking-[-0.02em]">{{ $v }}<span class="ml-1 text-[13px] font-light text-white/60">{{ $u }}</span></dt>
                            <dd class="mt-2 text-[10.5px] uppercase tracking-[0.22em] text-white/50">{{ $l }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            {{-- Form kartı --}}
            <div id="randevu" data-reveal style="--d:200ms" class="relative">
                <div class="relative overflow-hidden rounded-[24px] bg-white p-6 shadow-[0_50px_100px_-40px_rgba(0,0,0,.7)] sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-medium uppercase tracking-[0.28em] text-brand-600">{{ __('forms.consultation.dm-kicker') }}</p>
                            <p class="mt-2 text-[22px] font-light leading-snug tracking-[-0.01em] text-main-900">{{ __('forms.consultation.dm-title') }}</p>
                            <x-quota-note class="mt-2">Muayene günü kontenjanı sınırlıdır</x-quota-note>
                        </div>
                        <span class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 sm:inline-flex"><i class="fa-solid fa-tooth text-[15px]"></i></span>
                    </div>
                    <div class="mt-5">
                        <livewire:ui.forms.simple-form layout="lead-compact" variant="light"
                            :email-required="true" :require-consent="true" form-key="hero" />
                    </div>
                    <div class="mt-4 flex flex-wrap items-center justify-between gap-2 border-t border-main-100 pt-4 text-[12px] text-main-500">
                        <span class="inline-flex items-center gap-1.5 font-normal text-[#b07d34]"><i class="fa-solid fa-lock text-[11px] text-[#c9973f]"></i> Bilgileriniz gizli tutulur</span>
                        <span class="inline-flex items-center gap-1.5"><i class="fa-regular fa-clock text-[11px] text-brand-600"></i> Ortalama 30 dk’da dönüş</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============ 2. KAYAN ŞERİT (koyu) ============ --}}
    <div class="overflow-hidden border-y border-main-100 bg-white py-4" aria-hidden="true">
        <div class="flex w-max animate-marquee gap-10 whitespace-nowrap">
            @foreach(range(1, 2) as $_)
                @foreach(['Neredeyse görünmez', 'Çıkarılabilir', 'Yiyecek kısıtlaması yok', '3D dijital planlama', 'Tel ve braket yok', 'Daha az kontrol', 'Konforlu ve pürüzsüz', 'Çocuk · Genç · Yetişkin'] as $t)
                    <span class="inline-flex items-center gap-10 text-[15px] font-thin tracking-[0.02em] text-main-900">
                        {{ $t }} <i class="fa-solid fa-diamond text-[7px] text-brand-400"></i>
                    </span>
                @endforeach
            @endforeach
        </div>
    </div>

    {{-- ============ 4. INVISALIGN NEDİR (fotoğraf mozaiği + metin) ============ --}}
    <section class="isolate relative overflow-clip bg-ivory py-16 lg:py-24">
        <x-mark-watermark class="-right-28 top-12 h-[440px]" />
        <div class="mx-auto grid max-w-site items-center gap-12 px-5 lg:grid-cols-[1.05fr_.95fr] lg:gap-16 lg:px-8">
            {{-- Kompozisyon: büyük portre + üstüne binen ürün fotoğrafı + bilgi kartı --}}
            <div data-reveal class="relative pr-8 pb-12 sm:pr-16 sm:pb-16">
                <div class="overflow-hidden rounded-[30px] shadow-[0_40px_80px_-50px_rgba(0,38,23,.55)]">
                    <img src="{{ asset('img/lp/invisalign/aligner-smile.webp') }}" alt="Şeffaf plağını takarken gülümseyen hasta" loading="lazy"
                         class="aspect-[4/4] w-full object-cover object-[52%_55%]">
                </div>

                <div class="absolute right-0 bottom-0 w-[48%] overflow-hidden rounded-[24px] border-[6px] border-ivory shadow-[0_30px_60px_-30px_rgba(0,38,23,.5)]">
                    <img src="{{ asset('img/lp/invisalign/aligner-grey.webp') }}" alt="Şeffaf plaklar" loading="lazy"
                         class="aspect-[4/3] w-full object-cover">
                </div>

                <div class="absolute top-8 -left-3 rounded-2xl bg-white/95 px-5 py-4 shadow-[0_24px_48px_-24px_rgba(0,38,23,.45)] ring-1 ring-main-100 backdrop-blur sm:-left-8">
                    <p class="mb-2 text-[11.5px] text-main-400">Geleneksel tel tedavisine göre</p>
                    <p class="text-[34px] font-extralight leading-none tracking-[-0.02em] text-main-900">%60<span class="ml-0.5 text-[13px] font-light text-brand-700">’a varan</span></p>
                    <p class="mt-1.5 text-[11px] uppercase tracking-[0.2em] text-main-500">Kısa tedavi süresi</p>
                </div>
            </div>

            <div>
                <p data-reveal class="eyebrow flex items-center gap-4">
                    <span class="h-px w-10 bg-brand-600"></span>
                    <span lang="en">Invisalign</span>
                </p>
                <h2 data-reveal style="--d:60ms" class="mt-4 text-[26px] leading-[1.15] tracking-[-0.02em] text-main-900 sm:text-[32px] lg:text-[34px] xl:text-[38px]">
                    <span class="block font-thin lg:whitespace-nowrap">Size Özel Şeffaf Plaklarla</span>
                    <span class="block font-light lg:whitespace-nowrap">Adım Adım Düzgün Dişler</span>
                </h2>
                <span data-reveal style="--d:90ms" class="accent-line mt-6"></span>
                <p data-reveal style="--d:120ms" class="mt-6 text-[16.5px] leading-relaxed text-main-500">
                    Invisalign, dişlerinizin dijital taramasına göre size özel üretilen şeffaf plaklardan oluşur. Her yeni plak dişlerinizi hedeflenen konuma biraz daha yaklaştırır.
                </p>
                <p data-reveal style="--d:160ms" class="mt-4 text-[16.5px] font-normal leading-relaxed text-main-800">
                    Tel ve braket kullanılmaz. Plakları yemek yerken ve dişlerinizi fırçalarken çıkarıp sonra tekrar takarsınız.
                </p>

                <dl data-reveal style="--d:200ms" class="mt-8 grid max-w-md grid-cols-2 gap-3">
                    @foreach(array_slice($facts, 1, 2) as $f)
                        <div class="rounded-2xl border border-main-200/80 bg-white px-5 py-4">
                            <dt class="flex items-baseline gap-1.5 text-main-900">
                                <span class="text-[28px] font-extralight leading-none tracking-[-0.02em]">{{ $f['value'] }}</span>
                                <span class="text-[14px] font-light text-brand-700">{{ $f['unit'] }}</span>
                            </dt>
                            <dd class="mt-2 text-[13px] leading-snug text-main-500">{{ $f['label'] }}</dd>
                        </div>
                    @endforeach
                </dl>

                <a data-reveal style="--d:240ms" href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                   class="btn-accent mt-8 inline-flex items-center gap-2 rounded-xl px-6 py-3.5 text-[12.5px] font-semibold uppercase tracking-[0.16em]">
                    <i class="fa-brands fa-whatsapp text-[16px]"></i> WhatsApp’tan bilgi alın <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- ============ 5. TEDAVİ EDİLEN DURUMLAR (videolu) ============ --}}
    <section id="vakalar" class="isolate relative overflow-clip bg-white py-16 lg:py-24"
             x-data="{
                items: @js($caseItems),
                active: 0,
                progress: 0,
                timer: null,
                get current() { return this.items[this.active] },
                select(i) {
                    if (i === this.active) return;
                    this.active = i;
                    this.progress = 0;
                    this.$nextTick(() => this.play());
                },
                play() {
                    clearTimeout(this.timer);
                    const v = this.$refs.video;
                    if (v.getAttribute('src') !== this.current.video) v.src = this.current.video;
                    v.currentTime = 0;
                    v.play().catch(() => {});
                },
                onTime(e) { const v = e.target; this.progress = v.duration ? v.currentTime / v.duration : 0 },
                onEnded() {
                    this.progress = 1;
                    this.timer = setTimeout(() => this.play(), 1800);
                },
             }">
        <x-mark-watermark class="-left-32 top-24 h-[460px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">

            <div class="mx-auto max-w-2xl text-center" data-reveal>
                <p class="eyebrow text-brand-700">Tedavi edilen durumlar</p>
                <h2 class="section-title mt-3">Gülüşünüze En Çok Benzeyen Durumu Seçin</h2>
                <p class="mt-4 text-[16px] leading-relaxed text-main-500">
                    Birçok ortodontik sorun şeffaf plaklarla tel takmadan düzeltilebilir. Size benzeyen duruma dokunun, dişlerin nasıl hareket ettiğini izleyin.
                </p>
            </div>

            {{-- Sekmeler --}}
            <div class="mt-8 lg:mt-10">
                <div class="grid grid-cols-4 gap-2 sm:gap-3 lg:grid-cols-8">
                    @foreach($caseItems as $i => $case)
                        <button type="button" @click="select({{ $i }})"
                                :class="active === {{ $i }}
                                    ? 'bg-white text-brand-800 ring-2 ring-brand-600 shadow-[0_16px_34px_-18px_rgba(0,38,23,.45)] -translate-y-0.5'
                                    : 'bg-ivory text-main-700 ring-1 ring-main-200/70 hover:bg-white hover:ring-brand-300'"
                                class="flex min-w-0 cursor-pointer flex-col items-center rounded-xl px-1.5 pt-2.5 pb-3 text-center transition duration-300 sm:rounded-2xl sm:px-3 sm:pt-4 sm:pb-5">
                            <span class="flex min-h-[2.4rem] items-center text-[10.5px] leading-tight font-normal break-words hyphens-auto sm:min-h-[2.5rem] sm:text-[13.5px]">{{ $case['title'] }}</span>
                            <span aria-hidden="true"
                                  :class="active === {{ $i }} ? 'text-brand-700' : 'text-main-600'" class="mt-2 block aspect-[2.4] w-full bg-current transition-colors sm:mt-3"
                                  style="-webkit-mask: url('{{ asset('img/invisalign/bite/' . $case['key'] . '.svg') }}') center / contain no-repeat; mask: url('{{ asset('img/invisalign/bite/' . $case['key'] . '.svg') }}') center / contain no-repeat;"></span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Panel --}}
            <div data-reveal class="mt-8 grid gap-8 rounded-[28px] bg-white p-4 shadow-[0_40px_80px_-50px_rgba(0,30,18,.5)] ring-1 ring-main-100 sm:p-6 lg:grid-cols-[1.25fr_1fr] lg:gap-12 lg:p-8"
                 x-intersect.once="play()">

                <div>
                    <div class="relative overflow-hidden rounded-2xl bg-white">
                        <video x-ref="video" muted playsinline preload="none"
                               @timeupdate="onTime($event)" @ended="onEnded()"
                               class="aspect-[1.54] w-full object-cover"></video>
                    </div>

                    {{-- Önce → Sonra --}}
                    <div class="mt-4 flex items-center gap-4 px-1">
                        <span class="text-[12.5px] font-semibold text-main-500">Önce</span>
                        <div class="h-1.5 flex-1 overflow-hidden rounded-full bg-main-100">
                            <div class="h-full rounded-full bg-brand-600 transition-[width] duration-300 ease-linear"
                                 :style="`width:${Math.round(progress * 100)}%`"></div>
                        </div>
                        <span :class="progress > .97 ? 'text-brand-700' : 'text-main-500'" class="text-[12.5px] font-semibold transition">Sonra</span>
                    </div>
                    <p class="mt-3 px-1 text-[12px] text-main-400">Sadece gösterim amaçlıdır. Sonuçlar kişiden kişiye farklılık gösterir.</p>
                </div>

                <div class="flex flex-col lg:justify-center" x-cloak>
                    <h3 class="text-[26px] font-light leading-tight tracking-[-0.01em] text-main-900" x-text="current.title"></h3>
                    <p class="mt-2.5 text-[15px] leading-relaxed text-main-600" x-text="current.lead"></p>

                    <p class="mt-5 text-[11.5px] font-medium uppercase tracking-[0.16em] text-main-400">Tedavi edilmezse</p>
                    <ul class="mt-2.5 space-y-2">
                        <template x-for="r in current.risks.slice(0, 2)" :key="r">
                            <li class="flex items-start gap-2.5 text-[14.5px] text-main-700">
                                <i class="fa-solid fa-circle-exclamation mt-[3px] text-[12px] text-amber-500"></i>
                                <span x-text="r"></span>
                            </li>
                        </template>
                    </ul>

                    <div class="mt-5 rounded-2xl bg-main-50 px-4 py-3.5 ring-1 ring-main-200/60">
                        <p class="flex items-center gap-2 text-[12.5px] font-medium text-brand-800">
                            <i class="fa-solid fa-wand-magic-sparkles"></i> <span lang="en">Invisalign</span> ile
                        </p>
                        <p class="mt-1 text-[14px] leading-relaxed text-main-700" x-text="current.fix"></p>
                    </div>

                    <button type="button"
                            @click="Livewire.dispatch('open-book-consultation', { topic: current.title })"
                            class="{{ $btnAccent }} mt-6 cursor-pointer self-start">
                        Muayene gününe katılın
                        <i class="fa-solid fa-arrow-right text-[11px]"></i>
                    </button>
                    <x-quota-note class="mt-3">Kontenjan dolmadan yerinizi alın</x-quota-note>
                </div>
            </div>
        </div>
    </section>



    {{-- ============ 6b. YATAY FORM BANDI ============ --}}
    <section id="randevu-band" class="relative isolate overflow-hidden bg-brand-900">
        {{-- Arka plan: klinik binası + lacivert perde --}}
        <img src="{{ asset('img/lp/invisalign/retainer-case.webp') }}" alt="" aria-hidden="true" loading="lazy"
             class="absolute inset-0 -z-20 h-full w-full object-cover object-[50%_45%]">
        <div aria-hidden="true" class="absolute inset-0 -z-10 bg-gradient-to-r from-brand-900/[.97] via-brand-900/[.95] to-brand-900/[.93]"></div>
        <div aria-hidden="true" class="absolute inset-0 -z-10 bg-[radial-gradient(60%_120%_at_0%_0%,rgba(13,111,74,.3),transparent_60%)]"></div>

        <div class="mx-auto grid max-w-site gap-8 px-5 py-12 lg:grid-cols-[minmax(0,380px)_minmax(0,1fr)] lg:items-center lg:gap-12 lg:px-8 lg:py-14">
            <div data-reveal>
                <p class="flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.32em] text-brand-200"><span class="h-px w-8 bg-brand-300/70"></span>3D tarama · Ortodonti muayenesi</p>
                <h2 class="mt-4 text-[34px] leading-[1.1] tracking-[-0.02em] text-white lg:text-[42px]"><span class="block font-thin">Muayene Gününe</span><span class="block font-light whitespace-nowrap">Davetlisiniz</span></h2>
                <p class="mt-3 text-[14px] leading-relaxed text-white/60">Ekibimiz sizi arayıp uygun saati birlikte belirler.</p>
                <x-quota-note tone="dark" class="mt-4">Muayene günü için kalan yerler sınırlı</x-quota-note>
                <p class="mt-5 inline-flex items-center gap-2 text-[13px] text-[#e2b979]"><i class="fa-solid fa-lock text-[11px] text-[#d7a95f]"></i> Bilgileriniz gizli tutulur</p>
            </div>

            <div data-reveal style="--d:120ms">
                <livewire:ui.forms.simple-form layout="lead-band" variant="dark"
                    :email-required="true" :require-consent="true" form-key="band" />
            </div>
        </div>
    </section>

    {{-- ============ 6. AVANTAJLAR (ortada fotoğraf, iki yanda özellikler) ============ --}}
    @php
        $benefitCols = array_chunk($benefits, 3);
    @endphp
    <section id="tedavi-sureci" class="isolate relative overflow-clip {{ config('brand.features.lucky_spin') ? 'bg-ivory' : 'bg-white' }} py-16 lg:py-24">
        <x-mark-watermark class="-right-24 bottom-10 h-[400px]" />
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute top-1/2 left-1/2 h-[620px] w-[620px] -translate-x-1/2 -translate-y-1/3 rounded-full bg-brand-100/60 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-site px-5 lg:px-8">
            <div data-reveal class="mx-auto max-w-2xl text-center">
                <p class="eyebrow flex items-center justify-center gap-4"><span class="h-px w-10 bg-brand-600"></span>Avantajlar<span class="h-px w-10 bg-brand-600"></span></p>
                <h2 class="mt-5 text-[clamp(30px,3.4vw,46px)] leading-[1.12] tracking-[-0.02em] text-main-900">
                    <span class="block font-thin">Günlük Hayatınıza</span>
                    <span class="block font-light">Uyum Sağlayan Bir Tedavi</span>
                </h2>
                <p class="mx-auto mt-5 max-w-md text-[15px] leading-relaxed text-main-500">Yemek yerken, konuşurken ya da fotoğraf çekilirken tedavinizi düşünmenize gerek kalmaz.</p>
            </div>

            <div class="mt-14 grid grid-cols-1 items-center gap-12 lg:mt-16 lg:grid-cols-[1fr_minmax(0,380px)_1fr] lg:gap-14">

                {{-- Sol sütun --}}
                <ul class="order-2 space-y-8 lg:order-1 lg:space-y-12">
                    @foreach($benefitCols[0] as $b)
                        <li data-reveal style="--d: {{ $loop->index * 90 }}ms" class="group flex items-start gap-5 lg:flex-row-reverse lg:text-right">
                            <span class="relative inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-brand-700 shadow-[0_10px_24px_-14px_rgba(0,38,23,.5)] ring-1 ring-main-200/80 transition duration-300 group-hover:bg-brand-700 group-hover:text-white group-hover:ring-brand-700">
                                <i class="fa-solid {{ $b['icon'] }} text-[15px]"></i>
                                <span aria-hidden="true" class="absolute top-1/2 -left-12 hidden h-px w-10 bg-gradient-to-l from-brand-300 to-transparent lg:block lg:-right-12 lg:left-auto lg:bg-gradient-to-r"></span>
                            </span>
                            <div>
                                <h3 class="text-[18px] font-normal tracking-[-0.01em] text-main-900">{{ $b['title'] }}</h3>
                                <p class="mt-1.5 text-[14px] leading-relaxed text-main-500 lg:ml-auto lg:max-w-[260px]">{{ $b['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Orta: kemer fotoğraf --}}
                <div data-reveal class="relative order-1 mx-auto w-full max-w-[380px] lg:order-2">
                    <div class="absolute -inset-3 rounded-t-full rounded-b-[36px] border border-brand-200/80"></div>
                    <div class="relative aspect-[4/5] overflow-hidden rounded-t-full rounded-b-[28px] bg-main-100 shadow-[0_50px_90px_-50px_rgba(0,38,23,.6)]">
                        <img src="{{ asset('img/lp/invisalign/aligner-hold.webp') }}" alt="Şeffaf plağını tutan gülümseyen hasta" loading="lazy"
                             class="h-full w-full object-cover object-[76%_50%]">
                        <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-t from-brand-900/35 via-transparent to-transparent"></div>
                    </div>

                    <div class="absolute -bottom-5 left-1/2 flex -translate-x-1/2 items-center gap-3 whitespace-nowrap rounded-full bg-white py-2 pr-5 pl-2 shadow-[0_18px_40px_-20px_rgba(0,38,23,.55)] ring-1 ring-main-100">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-brand-700 text-white"><i class="fa-regular fa-clock text-[13px]"></i></span>
                        <span class="text-[13.5px] text-main-700"><span class="font-normal text-main-900">20–22 saat</span> günlük kullanım</span>
                    </div>
                </div>

                {{-- Sağ sütun --}}
                <ul class="order-3 space-y-8 lg:space-y-12">
                    @foreach($benefitCols[1] as $b)
                        <li data-reveal style="--d: {{ $loop->index * 90 + 120 }}ms" class="group flex items-start gap-5">
                            <span class="relative inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white text-brand-700 shadow-[0_10px_24px_-14px_rgba(0,38,23,.5)] ring-1 ring-main-200/80 transition duration-300 group-hover:bg-brand-700 group-hover:text-white group-hover:ring-brand-700">
                                <i class="fa-solid {{ $b['icon'] }} text-[15px]"></i>
                                <span aria-hidden="true" class="absolute top-1/2 -left-12 hidden h-px w-10 bg-gradient-to-l from-brand-300 to-transparent lg:block"></span>
                            </span>
                            <div>
                                <h3 class="text-[18px] font-normal tracking-[-0.01em] text-main-900">{{ $b['title'] }}</h3>
                                <p class="mt-1.5 max-w-[260px] text-[14px] leading-relaxed text-main-500">{{ $b['text'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @if(config('brand.features.lucky_spin'))
    {{-- ============ 15b. ŞANS ÇARKI ============ --}}
    <section id="cark" class="isolate relative overflow-clip bg-white py-16 lg:py-24">
        <x-mark-watermark class="-left-28 top-16 h-[420px]" />
        <div data-reveal class="mx-auto max-w-site px-5 lg:px-8">
            <livewire:ui.forms.lucky-spin />
        </div>
    </section>
    @endif

    {{-- ============ 7b. YAKLAŞIM (Atom tarzı: solda metin, sağda kenardan eriyen fotoğraf + yuvarlak detay) ============ --}}
    <section id="surec" class="relative isolate overflow-hidden bg-ivory">
        {{-- Sağ: kenardan eriyen büyük fotoğraf --}}
        <div aria-hidden="true" class="relative h-[340px] sm:h-[420px] lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[56%]">
            <img src="{{ asset('img/lp/invisalign/aligner-closeup.webp') }}" alt="" loading="lazy"
                 class="h-full w-full object-cover object-[50%_45%] [mask-image:linear-gradient(to_bottom,black_65%,transparent)] lg:[mask-image:linear-gradient(to_right,transparent_0%,rgba(0,0,0,.35)_18%,rgba(0,0,0,.8)_34%,black_48%)]">
        </div>

        {{-- İnce çapraz çizgi --}}
        <svg aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-[43%] hidden h-full w-[14%] lg:block" viewBox="0 0 100 100" preserveAspectRatio="none">
            <line x1="0" y1="0" x2="100" y2="100" stroke="currentColor" stroke-width=".6" vector-effect="non-scaling-stroke" class="text-main-300/70" />
        </svg>

        <div class="relative mx-auto max-w-site px-5 pb-16 lg:px-8 lg:py-28">
            <div class="max-w-[560px]">
                <p data-reveal class="-mt-8 inline-flex items-center gap-3 rounded-xl bg-white py-2 pr-4 pl-2 text-[13.5px] text-main-600 shadow-[0_10px_30px_-18px_rgba(0,38,23,.45)] ring-1 ring-main-200/80 lg:mt-0">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700"><i class="fa-solid fa-gem text-[12px]"></i></span>
                    <span><span class="font-medium text-main-900">Plak sistemi:</span> <span lang="en">Invisalign® · Align Technology</span></span>
                </p>

                <h2 data-reveal style="--d:60ms" class="mt-8 text-[clamp(34px,4vw,54px)] leading-[1.1] tracking-[-0.025em] text-main-900">
                    <span class="block font-thin">Dijital Planlamayla</span>
                    <span class="block font-light">Öngörülebilir Sonuçlar</span>
                </h2>
                <span data-reveal style="--d:100ms" class="mt-5 block h-px w-full max-w-[420px] bg-gradient-to-r from-[#c9973f] via-[#c9973f]/60 to-transparent"></span>

                <p data-reveal style="--d:140ms" class="mt-8 text-[16.5px] leading-[1.8] text-main-700">
                    Kahraman Ortodonti’de her tedavi, dişlerinizin üç boyutlu dijital taramasıyla başlar. Yrd. Doç. Dr. Fatih Kahraman plaklarınızın her aşamasını önceden planlar. Dişlerinizin hangi aşamada nasıl hareket edeceğini tedaviye başlamadan birlikte inceleriz.
                </p>
                <p data-reveal style="--d:180ms" class="mt-5 text-[16.5px] leading-[1.8] text-main-700">
                    Plaklarınız bu plana göre üretilir. Kontrollerde ilerlemeyi birlikte takip eder, gerekirse planı güncelleriz.
                </p>

                <button data-reveal style="--d:220ms" type="button" onclick="Livewire.dispatch('open-book-consultation')" class="{{ $btnAccent }} mt-9">
                    Yerinizi Ayırtın <i class="fa-solid fa-arrow-right text-[11px]"></i>
                </button>
                <x-quota-note data-reveal style="--d:260ms" class="mt-3">Her muayene günü sınırlı sayıda kişiyle planlanır</x-quota-note>
            </div>
        </div>

        {{-- Yuvarlak detay fotoğrafı --}}
        <div aria-hidden="true" class="absolute right-[8%] bottom-[9%] hidden h-[210px] w-[210px] rounded-full bg-white/30 p-2.5 shadow-[0_30px_60px_-24px_rgba(0,38,23,.55)] ring-1 ring-white/70 backdrop-blur-sm lg:block xl:h-[230px] xl:w-[230px]">
            <img src="{{ asset('img/lp/invisalign/aligner-white.webp') }}" alt="" loading="lazy"
                 class="h-full w-full rounded-full object-cover object-center">
        </div>
    </section>

    {{-- ============ 7. KARŞILAŞTIRMA (fildişi) ============ --}}
    <section id="karsilastir" class="isolate relative overflow-clip bg-white py-16 lg:py-24">
        <x-mark-watermark class="-right-28 top-10 h-[420px]" />
        <div class="mx-auto grid max-w-site gap-10 px-5 lg:grid-cols-[.8fr_1.2fr] lg:gap-14 lg:px-8">
            <div data-reveal class="lg:self-center">
                <p class="eyebrow text-brand-700">Neden <span lang="en">Invisalign</span>?</p>
                <h2 class="section-title mt-3">Telli Tedavi İle Karşılaştırın</h2>
                <p class="mt-5 text-[16px] leading-relaxed text-main-500">
                    İki yöntem de dişleri düzeltir; fark günlük hayatta ortaya çıkar. Size hangisinin uygun olduğuna muayenede birlikte karar veririz.
                </p>
                <button type="button" onclick="Livewire.dispatch('open-book-consultation')" class="{{ $btnDark }} mt-8">
                    İletişime geçin <i class="fa-solid fa-arrow-right text-[12px]"></i>
                </button>
            </div>

            <div data-reveal style="--d:120ms" class="overflow-hidden rounded-[26px] bg-white shadow-[0_40px_80px_-50px_rgba(0,30,18,.45)] ring-1 ring-main-200/70">
                <div class="grid grid-cols-[minmax(0,.85fr)_minmax(0,1.1fr)_minmax(0,1fr)] text-[12.5px] font-semibold sm:text-[14px]">
                    <div class="px-3 py-5 sm:px-6"></div>
                    <div class="bg-brand-700 px-3 py-5 text-white sm:px-6">Invisalign®</div>
                    <div class="px-3 py-5 text-main-400 sm:px-6">Telli tedavi</div>
                </div>
                @foreach($compareRows as $row)
                    <div class="grid grid-cols-[minmax(0,.85fr)_minmax(0,1.1fr)_minmax(0,1fr)] border-t border-main-100 text-[12.5px] break-words hyphens-auto sm:text-[14.5px]">
                        <div class="px-3 py-4 font-semibold text-main-900 sm:px-6">{{ $row['label'] }}</div>
                        <div class="flex items-start gap-1.5 bg-main-50 px-3 py-4 text-main-800 sm:gap-2 sm:px-6">
                            <i class="fa-solid fa-circle-check mt-1 shrink-0 text-[12px] text-brand-600 sm:text-[13px]"></i><span class="min-w-0">{{ $row['inv'] }}</span>
                        </div>
                        <div class="flex items-start gap-1.5 px-3 py-4 text-main-400 sm:gap-2 sm:px-6">
                            <i class="fa-solid fa-circle-xmark mt-1 shrink-0 text-[12px] text-main-300 sm:text-[13px]"></i><span class="min-w-0">{{ $row['tel'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ============ 8. ÜCRETSİZ DİŞ ANALİZİ (Zürih'teki adım adım form) ============ --}}
    <section id="analiz" class="relative isolate overflow-clip bg-ivory py-16 lg:py-24">
        <x-mark-watermark class="-left-24 bottom-6 h-[380px]" />
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(60%_50%_at_50%_0%,rgba(13,111,74,.12),transparent_70%),radial-gradient(45%_45%_at_100%_100%,rgba(201,151,63,.06),transparent_70%)]"></div>
        <div aria-hidden="true" class="bg-dots pointer-events-none absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-site px-5 lg:px-8">
            <div data-reveal class="mx-auto max-w-2xl text-center">
                <span class="inline-flex items-center gap-2.5 rounded-full border border-main-200/80 bg-white/80 px-4 py-1.5 text-[11.5px] font-semibold uppercase tracking-[0.22em] text-main-600 backdrop-blur">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#c9973f]"></span> 3 adım · 30 saniye
                </span>
                <h2 class="mt-6 text-[clamp(32px,4vw,52px)] leading-[1.1] tracking-[-0.02em] font-light text-brand-900">Online <span class="font-semibold">Ön Değerlendirme</span></h2>
                <p class="mx-auto mt-5 max-w-xl text-[16px] leading-relaxed text-main-500">
                    Birkaç soruyu yanıtlayın; sizi arayıp sorularınızı cevaplayalım ve 3D tarama ve muayene günü için uygun saati birlikte belirleyelim.
                </p>
            </div>

            <div data-reveal class="relative mx-auto mt-12 max-w-6xl lg:mt-14">
                <livewire:ui.forms.step-form :key="'step-form-invisalign'" />
            </div>

            <ul data-reveal class="mx-auto mt-10 flex max-w-4xl flex-col items-center justify-center gap-4 text-[13.5px] text-main-600 sm:flex-row sm:gap-10 lg:mt-12">
                <li class="flex items-center gap-2.5"><i class="fa-solid fa-user-doctor text-[14px] text-brand-600"></i> Hekim değerlendirmesi</li>
                <li class="hidden h-4 w-px bg-main-200 sm:block"></li>
                <li class="flex items-center gap-2.5"><i class="fa-solid fa-clipboard-check text-[14px] text-brand-600"></i> Size özel tedavi önerisi</li>
                <li class="hidden h-4 w-px bg-main-200 sm:block"></li>
                <li class="flex items-center gap-2.5"><i class="fa-solid fa-lock text-[13px] text-brand-600"></i> Bilgileriniz gizli tutulur</li>
            </ul>
        </div>
    </section>

    {{-- ============ 7c. MESAİ SONRASI (İstanbul — pazartesi–cumartesi 19:30'a kadar) ============ --}}
    @php($blk = config('brand.branches.istanbul'))
    <section id="mesai-sonrasi" class="relative isolate overflow-hidden bg-brand-900">
        {{-- Sağ: klinik binası, soldan laciverte eriyerek --}}
        <div aria-hidden="true" class="relative h-[240px] sm:h-[320px] lg:absolute lg:inset-y-0 lg:right-0 lg:h-auto lg:w-[55%]">
            <img src="{{ asset('img/lp/invisalign/scan-screen.webp') }}" alt="" loading="lazy" class="h-full w-full object-cover object-[50%_45%]">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-900 via-brand-900/40 to-brand-900/10 lg:bg-gradient-to-r lg:from-brand-900 lg:via-brand-900/55 lg:to-brand-900/15"></div>
        </div>

        <div class="relative mx-auto max-w-site px-5 pb-16 lg:px-8 lg:py-24">
            <div class="max-w-[560px]">
                <p data-reveal class="-mt-6 inline-flex items-center gap-3 text-[11.5px] font-medium uppercase tracking-[0.3em] text-brand-200 lg:mt-0">
                    <i class="fa-solid fa-moon text-[12px] text-[#e2b979]"></i> Mesai sonrası da yanınızdayız
                </p>
                <h2 data-reveal style="--d:60ms" class="mt-5 text-[clamp(32px,3.6vw,48px)] leading-[1.12] tracking-[-0.02em] font-light text-white">
                    Cumartesi Dahil <span class="font-semibold">Akşam 19:30’a Kadar</span> Açığız
                </h2>
                <p data-reveal style="--d:120ms" class="mt-5 text-[16px] leading-relaxed text-white/70">
                    Bakırköy Ataköy Towers’taki kliniğimiz pazartesiden cumartesiye 09:00–19:30 arası açık. İş çıkışı muayene ve kontrol randevunuzu kolayca planlayın.
                </p>
                <div data-reveal style="--d:180ms" class="mt-9 flex flex-wrap gap-3">
                    <button type="button" onclick="Livewire.dispatch('open-book-consultation')"
                            class="inline-flex cursor-pointer items-center gap-2.5 rounded-full bg-white px-6 py-3.5 text-[15px] font-medium text-brand-900 shadow-[0_14px_30px_-16px_rgba(0,0,0,.6)] transition hover:bg-brand-50">
                        <i class="fa-regular fa-calendar-check text-[15px] text-brand-700"></i> Yerinizi Ayırtın
                    </button>
                    <a href="{{ $blk['maps_link'] }}" target="_blank" rel="noopener"
                       class="inline-flex items-center gap-2.5 rounded-full border border-white/30 px-6 py-3.5 text-[15px] font-medium text-white transition hover:border-white/60 hover:bg-white/5">
                        <i class="fa-solid fa-diamond-turn-right text-[14px] text-[#e2b979]"></i> Yol Tarifi Alın
                    </a>
                </div>
                <x-quota-note tone="dark" data-reveal style="--d:220ms" class="mt-4">İş çıkışı saatlerimizde kontenjan sınırlı</x-quota-note>
            </div>
        </div>
    </section>

    {{-- ============ 11. HEKİM (fildişi) ============ --}}
    <section id="hekim" class="isolate relative overflow-clip bg-ivory py-16 lg:py-24">
        <x-mark-watermark class="-right-28 bottom-8 h-[420px]" />
        <div class="mx-auto grid max-w-site items-center gap-12 px-5 lg:grid-cols-[1fr_1fr] lg:items-stretch lg:gap-16 lg:px-8">
            <div data-reveal class="relative -mx-1 w-auto sm:mx-auto sm:w-full sm:max-w-md lg:max-w-none">
                <div aria-hidden="true" class="absolute -inset-6 rounded-[40px] bg-brand-200/40 blur-3xl"></div>
                <div class="relative overflow-hidden rounded-[30px] bg-white shadow-[0_40px_80px_-50px_rgba(0,38,23,.55)] ring-1 ring-main-200/80 lg:h-full lg:min-h-[560px]">
                    <img src="{{ asset('img/lp/invisalign/dr-fatih-kahraman.webp') }}" alt="{{ $doctor['name'] }}" loading="lazy"
                         width="960" height="1240" class="aspect-[4/5] h-auto w-full object-cover object-[50%_8%] sm:aspect-[960/1020] sm:object-top lg:absolute lg:inset-0 lg:aspect-auto lg:h-full">
                    {{-- Üyelikler ve sertifikalar --}}
                    <div class="absolute inset-x-0 bottom-0">
                        <div aria-hidden="true" class="h-10 bg-gradient-to-t from-white/95 to-transparent"></div>
                        <ul class="flex flex-nowrap items-center justify-between gap-x-2 bg-white/95 px-3 pt-1 pb-4 backdrop-blur-sm sm:justify-center sm:gap-x-5 sm:px-5 sm:pb-5 lg:gap-x-6">
                            @foreach([
                                ['aao',                  'American Association of Orthodontists üyesi', 'h-[15px] sm:h-[22px] lg:h-[26px]'],
                                ['invisalign-preferred', 'Invisalign Preferred Provider',               'h-[12px] sm:h-[19px] lg:h-[22px]'],
                                ['wfo',                  'World Federation of Orthodontists',           'h-[18px] sm:h-[27px] lg:h-[32px]'],
                                ['dsd-clinic',           'Digital Smile Design Clinic',                 'h-[13px] sm:h-[20px] lg:h-[24px]'],
                                ['eos',                  'European Orthodontic Society üyesi',          'h-[15px] sm:h-[22px] lg:h-[26px]'],
                            ] as [$logo, $label, $h])
                                <li class="shrink-0"><img src="{{ asset('img/lp/invisalign/memberships/' . $logo . '.webp') }}" alt="{{ $label }}" title="{{ $label }}" loading="lazy" class="{{ $h }} w-auto max-w-none"></li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Diamond rozeti --}}
                    <div class="absolute top-4 right-4 rounded-2xl bg-white/90 px-4 py-3 text-center shadow-[0_14px_30px_-18px_rgba(0,38,23,.6)] ring-1 ring-main-200/70 backdrop-blur-md">
                        <i class="fa-solid fa-gem text-[14px] text-brand-600"></i>
                        <p class="mt-1 text-[11px] font-semibold tracking-[0.18em] text-brand-700" lang="en">DIAMOND</p>
                        <p class="text-[10.5px] text-main-600"><span lang="en">Invisalign</span> · Top %1</p>
                        <p class="font-mono text-[10px] text-main-400">2021–2024</p>
                    </div>

                </div>
            </div>

            <div class="lg:flex lg:flex-col lg:justify-center lg:py-2">
                <h2 data-reveal style="--d:80ms" class="section-title">{{ $doctor['name'] }}</h2>
                <p data-reveal style="--d:120ms" class="mt-2 text-[15.5px] text-brand-700">Ortodonti Uzmanı <span class="text-main-300">·</span> <span class="text-main-500">DDS, PhD</span></p>

                <p data-reveal style="--d:160ms" class="mt-6 text-[16px] leading-relaxed text-main-600">
                    6 yıllık ortodonti uzmanlık eğitimini tamamlamış, Sağlık Bakanlığı onaylı bir ortodonti uzmanıdır. 15 yılı aşkın deneyimiyle İstanbul’da şeffaf plak, dijital ortodonti ve ameliyatsız çene genişletme tedavilerini bizzat yürütür. Yurt içi ve yurt dışı kongrelerde konuşmacı olarak yer alır.
                </p>

                {{-- Rakamlar --}}
                <dl data-reveal style="--d:200ms" class="mt-8 grid grid-cols-3 divide-x divide-main-200 rounded-2xl bg-white py-6 ring-1 ring-main-200/70">
                    @foreach([
                        ['15+', 'Yıl deneyim'],
                        ['41+', 'Bilimsel yayın ve ödül'],
                        ['Top %1', 'Invisalign Diamond'],
                    ] as [$num, $label])
                        <div class="px-2 text-center sm:px-4">
                            <dt class="text-[26px] leading-none font-light tracking-[-0.02em] text-brand-900 sm:text-[32px]">{{ $num }}</dt>
                            <dd class="mt-2 text-[12px] leading-snug text-main-500 sm:text-[13px] sm:whitespace-nowrap">{{ $label }}</dd>
                        </div>
                    @endforeach
                </dl>

                {{-- Uzmanlık alanları --}}
                <p data-reveal style="--d:240ms" class="mt-8 text-[11.5px] font-medium uppercase tracking-[0.18em] text-main-400">Uzmanlık alanları</p>
                <ul data-reveal style="--d:280ms" class="mt-3 flex flex-wrap gap-2">
                    @foreach(['Şeffaf plak (Invisalign)', 'Dijital ortodonti', 'Ameliyatsız çene genişletme (MARPE)', 'Erişkin ortodontisi', 'Erken yaş ortodontisi', 'Pekiştirme tedavisi'] as $item)
                        <li class="inline-flex items-center gap-2 rounded-full bg-white px-3.5 py-2 text-[13px] text-main-700 ring-1 ring-main-200/80">
                            <span class="h-1.5 w-1.5 rounded-full bg-[#c9973f]"></span>{{ $item }}
                        </li>
                    @endforeach
                </ul>

                <p data-reveal style="--d:320ms" class="mt-6 flex items-start gap-2.5 text-[13.5px] leading-relaxed text-main-500">
                    <i class="fa-solid fa-award mt-0.5 text-[13px] text-brand-600"></i>
                    <span><span lang="en">American Association of Orthodontists</span>, <span lang="en">European Orthodontic Society</span> ve <span lang="en">European Aligner Society</span> üyesi.</span>
                </p>

                <button data-reveal style="--d:360ms" type="button" onclick="Livewire.dispatch('open-book-consultation')" class="btn-accent mt-8 inline-flex cursor-pointer items-center justify-center gap-2 self-start rounded-xl px-5 py-3 text-[11.5px] font-semibold uppercase tracking-[0.16em]">
                    Yerinizi ayırtın <i class="fa-solid fa-arrow-right text-[10.5px]"></i>
                </button>
                <x-quota-note data-reveal style="--d:400ms" class="mt-3">Hekim görüşmesi için ayrılan yerler sınırlıdır</x-quota-note>
            </div>
        </div>
    </section>

    {{-- ============ 12. GOOGLE YORUMLARI (kayan, sürüklenebilir kartlar) ============ --}}
    <section id="yorumlar" class="isolate relative overflow-clip bg-white py-16 lg:py-24">
        <x-mark-watermark class="-left-28 top-8 h-[400px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div data-reveal>
                    <p class="eyebrow flex items-center gap-4"><span class="h-px w-10 bg-brand-600"></span>Google yorumları</p>
                    <h2 class="mt-5 text-[clamp(30px,3.4vw,46px)] leading-[1.12] tracking-[-0.02em] text-main-900">
                        <span class="font-thin">Hastalarımız</span> <span class="font-light">Neler Söylüyor?</span>
                    </h2>
                </div>
                <a data-reveal href="{{ config('brand.google_reviews_url') }}" target="_blank" rel="noopener" aria-label="Google yorumlarını görüntüle"
                   class="group inline-flex w-fit items-center gap-3 rounded-full bg-white py-2 pr-5 pl-2 shadow-[0_12px_30px_-20px_rgba(0,38,23,.5)] ring-1 ring-main-200/80 transition hover:ring-brand-200">
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-main-50">
                        <svg viewBox="0 0 48 48" class="h-5 w-5" aria-hidden="true">
                            <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 8 3l5.7-5.7C34 6.1 29.3 4 24 4 13 4 4 13 4 24s9 20 20 20 20-9 20-20c0-1.3-.1-2.6-.4-3.9z"/>
                            <path fill="#FF3D00" d="m6.3 14.7 6.6 4.8C14.7 16 19 12 24 12c3.1 0 5.8 1.2 8 3l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                            <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                            <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.6-.4-3.9z"/>
                        </svg>
                    </span>
                    <span class="flex gap-0.5 text-[12px] text-[#c9973f]">@for($s = 0; $s < 5; $s++)<i class="fa-solid fa-star"></i>@endfor</span>
                    <span class="text-[14px] font-semibold text-main-900">{{ config('brand.google_rating') }}</span>
                    <span class="text-[13.5px] text-main-500">Google puanı · {{ config('brand.google_reviews_count') }} yorum</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-main-400 transition group-hover:text-brand-600"></i>
                </a>
            </div>
        </div>

        {{-- Kayan kartlar: üzerine gelince durur, sürüklenebilir --}}
        <div data-reveal style="--d:120ms" class="mx-auto mt-12 max-w-site px-5 lg:px-8">
        <div class="reviews-marquee relative -my-6 overflow-hidden py-6"
             x-data="{
                x: 0, startX: 0, startT: 0, dragging: false, half: 0, paused: false, last: 0,
                init() {
                    this.half = this.$refs.track.scrollWidth / 2;
                    const step = (t) => {
                        const dt = this.last ? t - this.last : 0; this.last = t;
                        if (!this.dragging && !this.paused) this.set(this.x - dt * 0.035);
                        requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                },
                set(v) {
                    if (this.half > 0) { while (v <= -this.half) v += this.half; while (v > 0) v -= this.half; }
                    this.x = v; this.$refs.track.style.transform = `translate3d(${v}px,0,0)`;
                },
                down(e) { this.dragging = true; this.startX = e.clientX; this.startT = this.x },
                move(e) { if (this.dragging) this.set(this.startT + e.clientX - this.startX) },
                up() { this.dragging = false },
             }"
             @mouseenter="paused = true" @mouseleave="paused = false; up()">
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 left-0 z-10 w-10 bg-gradient-to-r from-white to-transparent sm:w-16"></div>
            <div aria-hidden="true" class="pointer-events-none absolute inset-y-0 right-0 z-10 w-10 bg-gradient-to-l from-white to-transparent sm:w-16"></div>

            <div x-ref="track" class="flex w-max cursor-grab gap-5 select-none active:cursor-grabbing"
                 @pointerdown="down($event)" @pointermove="move($event)" @pointerup="up()" @pointercancel="up()">
                @for($set = 0; $set < 2; $set++)
                    @foreach($reviews as $r)
                        <article @if($set) aria-hidden="true" @endif
                                 class="review-card flex w-[310px] shrink-0 flex-col rounded-3xl bg-ivory p-6 ring-1 ring-main-200/70 transition duration-300 hover:bg-white hover:shadow-[0_30px_60px_-40px_rgba(0,38,23,.55)] sm:w-[370px]">
                            <div class="flex items-center gap-3.5">
                                <span class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-brand-700 to-brand-900 text-[14px] font-medium text-white">{{ $r['initials'] }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-[15.5px] font-normal text-main-900">{{ $r['name'] }}</p>
                                    <p class="text-[12px] text-main-400">{{ $r['meta'] }}</p>
                                </div>
                                <svg viewBox="0 0 48 48" class="h-4.5 w-4.5 shrink-0 opacity-80" aria-hidden="true">
                                    <path fill="#FFC107" d="M43.6 20.1H42V20H24v8h11.3C33.7 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.2 8 3l5.7-5.7C34 6.1 29.3 4 24 4 13 4 4 13 4 24s9 20 20 20 20-9 20-20c0-1.3-.1-2.6-.4-3.9z"/>
                                    <path fill="#FF3D00" d="m6.3 14.7 6.6 4.8C14.7 16 19 12 24 12c3.1 0 5.8 1.2 8 3l5.7-5.7C34 6.1 29.3 4 24 4 16.3 4 9.7 8.3 6.3 14.7z"/>
                                    <path fill="#4CAF50" d="M24 44c5.2 0 9.9-2 13.4-5.2l-6.2-5.2C29.2 35.1 26.7 36 24 36c-5.2 0-9.6-3.3-11.3-8l-6.5 5C9.5 39.6 16.2 44 24 44z"/>
                                    <path fill="#1976D2" d="M43.6 20.1H42V20H24v8h11.3c-.8 2.2-2.2 4.2-4.1 5.6l6.2 5.2C37 39.2 44 34 44 24c0-1.3-.1-2.6-.4-3.9z"/>
                                </svg>
                            </div>
                            <div class="mt-4 flex items-center gap-2">
                                <span class="flex gap-0.5 text-[11px] text-[#c9973f]">@for($s = 0; $s < 5; $s++)<i class="fa-solid fa-star"></i>@endfor</span>
                                <span class="text-[12px] text-main-400">{{ $r['when'] }}</span>
                            </div>
                            <p class="review-text mt-3 text-[14.5px] leading-[1.75] text-main-700">{{ $r['text'] }}</p>
                        </article>
                    @endforeach
                @endfor
            </div>
        </div>
        </div>

        <div data-reveal class="mt-10 flex justify-center px-5">
            <a href="{{ config('brand.google_reviews_url') }}" target="_blank" rel="noopener"
               class="group inline-flex items-center gap-2.5 rounded-full px-5 py-2.5 text-[14px] font-medium text-brand-700 ring-1 ring-brand-200 transition hover:bg-brand-50 hover:ring-brand-300">
                Google’da {{ config('brand.google_reviews_count') }} yorumun tamamını okuyun
                <i class="fa-solid fa-arrow-up-right-from-square text-[11px] transition group-hover:translate-x-0.5"></i>
            </a>
        </div>
    </section>

    {{-- ============ 16. SSS + FORM (Atom tarzı) ============ --}}
    @php($faqIcons = ['fa-clock', 'fa-face-smile', 'fa-comment-dots', 'fa-utensils', 'fa-hourglass-half', 'fa-user-check', 'fa-credit-card', 'fa-eye', 'fa-calendar-check', 'fa-shield-heart'])
    <section id="sss" class="isolate relative overflow-clip bg-ivory py-16 lg:py-24">
        <x-mark-watermark class="-right-24 top-24 h-[440px]" />
        <div class="mx-auto max-w-site px-5 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div data-reveal>
                    <p class="eyebrow">Merak edilenler</p>
                    <h2 class="section-title mt-4">Sıkça Sorulan Sorular</h2>
                    <p class="mt-3 text-[16px] text-main-500">Invisalign tedavisi hakkında en sık sorulan sorular.</p>
                </div>
                <span data-reveal class="inline-flex items-center gap-2 self-start rounded-full border border-main-200 bg-white px-5 py-2.5 text-[13.5px] text-main-600 shadow-[0_10px_24px_-18px_rgba(17,17,20,.3)] lg:self-end">
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Ortalama yanıt süresi: <strong class="font-semibold text-main-900">30 dakika</strong>
                </span>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-[1.35fr_1fr] lg:gap-8">
                <div x-data="{ open: 0 }" class="space-y-3">
                    @foreach($faqItems as $i => $faq)
                        <div data-reveal style="--d: {{ $loop->index * 40 }}ms"
                             :class="open === {{ $i }} ? 'border-brand-300 shadow-[0_18px_40px_-28px_rgba(0,38,23,.45)]' : 'border-main-200/80'"
                             class="rounded-2xl border bg-white transition duration-300">
                            <button type="button" @click="open = open === {{ $i }} ? null : {{ $i }}"
                                    class="flex w-full cursor-pointer items-center gap-4 px-5 py-4 text-left sm:px-6">
                                <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                    <i class="fa-solid {{ $faqIcons[$i % count($faqIcons)] }} text-[13px]"></i>
                                </span>
                                <span class="flex-1 text-[16px] text-main-900">{{ $faq['q'] }}</span>
                                <span :class="open === {{ $i }} ? 'rotate-180 border-brand-300 text-brand-700' : 'border-main-200 text-main-500'"
                                      class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full border transition duration-300">
                                    <i class="fa-solid fa-chevron-down text-[11px]"></i>
                                </span>
                            </button>
                            <div x-show="open === {{ $i }}" x-collapse x-cloak>
                                <p class="px-5 pb-5 pl-[72px] text-[15px] leading-relaxed text-main-500 sm:px-6 sm:pl-[76px]">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <div data-reveal class="rounded-[22px] border border-main-200/80 bg-gradient-to-br from-white to-brand-50/60 p-6 sm:p-8 lg:sticky lg:top-24">
                        <p class="eyebrow">Randevu talebi</p>
                        <p class="mt-3 text-[26px] font-light leading-tight tracking-[-0.01em] text-main-900">Gülüşünüz için danışmanlık alın</p>
                        <p class="mt-2 text-[14.5px] text-main-500">Ekibimiz en kısa sürede sizinle iletişime geçecektir.</p>
                        <x-quota-note class="mt-3 mb-6">Kontenjan sınırlı, talebinizi erkenden bırakın</x-quota-note>
                        <livewire:ui.forms.simple-form layout="lead" variant="light"
                            :email-required="true" :require-consent="true" form-key="faq" submit-label="Hemen iletişime geçin" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Google için yapılandırılmış veri (klinik, hekim, şubeler, SSS) --}}
    @include('partials.schema', ['faqs' => $faqItems])
</div>
