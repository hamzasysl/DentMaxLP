{{-- resources/views/livewire/ui/forms/lucky-spin.blade.php --}}
@php
    // Validation
    $invalid = 'border-red-500/50 ring-1 ring-red-500/20 focus:border-red-500 focus:ring-red-500/30';
    $errorText = 'text-red-500';

    // Labels & hints
    $label = 'text-main-900/60';
    $hint  = 'text-gray-500';

    // Input field
    $field = 'border-gray-200 bg-white text-main-900
              placeholder:text-gray-400
              focus:border-brand-500 focus:ring-brand-500/20';

    // Success box
    $successBox = 'border-gray-200 bg-white text-main-900';

    // Alerts
    $alertBox = 'border-main-200 bg-white/80 text-main-900
                 backdrop-blur shadow-[0_16px_40px_rgba(0,0,0,0.06)]';

    $alertKicker = 'text-main-500';
    $alertBody   = 'text-main-700';

    // Status dots
    $dotSuccess = 'bg-brand-500 shadow-[0_0_0_3px_rgba(207,106,6,.10)]';
    $dotFail    = 'bg-red-500 shadow-[0_0_0_3px_rgba(239,68,68,.12)]';

    // Alert close button
    $alertClose = 'border-main-200 bg-white/70 text-main-500
                   hover:text-main-900 hover:border-main-300';

    // Headings
    $headingText = 'text-main-900';
    $subText     = 'text-gray-600';

        $items = array_values($prizes ?? []);
    $n = max(1, count($items));
@endphp


<div
    class="w-full"
    x-data
    data-lucky-spin
    data-instance-id="{{ $this->getId() }}"
    data-slice-count="{{ $n }}"
    data-spinning="0"
    @lucky-spin:locked.window="$wire.syncOffer($event.detail.result, $event.detail.sourceId)"
>


    {{-- OUTER PREMIUM CARD (wheel + form inside) --}}
    <div class="relative rounded-2xl  overflow-visible ">



        {{-- CONTENT  --}}
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12 lg:items-center">

            {{-- WHEEL (LEFT) --}}
            <div class="lg:col-span-6 flex items-center justify-center">
                <div class="relative aspect-square w-full max-w-[370px] md:max-w-[520px]"  wire:ignore>

                    @php
                        $items = array_values($prizes ?? []);
                        $n = max(1, count($items));

                        $theme = $theme ?? [];

                        // PIN gradient (CSS var veya renk)
                        $pgRaw = $theme['pin_grad'] ?? ['--color-brand-400','--color-brand-500','--color-brand-600'];
                        $pg = array_map(function ($v) {
                            return str_starts_with($v, '--') ? "var($v)" : $v;
                        }, $pgRaw);

                        $cx = 500; $cy = 500;
                        $R  = 450;           // dilimler rim içine sığsın
                        $startAngle = -90;   // top
                        $sliceDeg = 360 / $n;

                        $polar = function(float $deg, float $r) use ($cx, $cy) {
                            $rad = deg2rad($deg);
                            return [$cx + cos($rad) * $r, $cy + sin($rad) * $r];
                        };

                        $wedgePath = function(float $a0, float $a1, float $r) use ($cx, $cy, $polar) {
                            [$x0, $y0] = $polar($a0, $r);
                            [$x1, $y1] = $polar($a1, $r);
                            $large = (($a1 - $a0) > 180) ? 1 : 0;
                            return "M {$cx} {$cy} L {$x0} {$y0} A {$r} {$r} 0 {$large} 1 {$x1} {$y1} Z";
                        };

                        // color resolver (hex / css var)
                        $resolve = fn($v) => str_starts_with($v,'--') ? "var($v)" : $v;
                    @endphp

                    {{-- MARKER (top center, slightly inside) --}}
                    <div
                        id="wheelPin"
                        class="absolute left-1/2 -top-[18px] z-50 -translate-x-1/2"
                        style="will-change: transform;"
                    >
                        <div
                            id="luckyPinAnim"
                            style="width:56px;
                                height:56px;
                                display:inline-block;
                                will-change: transform;"
                        >


                            <svg
                                viewBox="0 0 80 115"
                                class="h-[36px] w-[36px]   translate-x-[30%]    translate-y-[20%] md:translate-y-[0%] md:translate-x-[0%]  lg:h-[56px] lg:w-[56px]"
                                style=" display:block;"
                                aria-hidden="true"
                            >
                                <defs>
                                    <linearGradient id="copperGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                        <stop offset="0%"  stop-color="{{ $pg[0] }}"/>
                                        <stop offset="45%" stop-color="{{ $pg[1] }}"/>
                                        <stop offset="100%" stop-color="{{ $pg[2] }}"/>
                                    </linearGradient>

                                    <clipPath id="pinHeadClip">
                                        <rect x="0" y="0" width="80" height="62"/>
                                    </clipPath>

                                    <clipPath id="pinTailClip">
                                        <rect x="0" y="56" width="80" height="59"/>
                                    </clipPath>
                                </defs>


                                {{-- HEAD: SABİT --}}
                                <g clip-path="url(#pinHeadClip)">
                                    <path
                                        fill="url(#copperGrad)"
                                        d="M40,0C17.9,0,0,17.7,0,39.4S40,115,40,115s40-53.9,40-75.6S62.1,0,40,0z
                                               M40,52.5c-7,0-12.6-5.6-12.6-12.4S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"
                                    />
                                    <path
                                        fill="rgba(0,0,0,0.18)"
                                        d="M40,20.5c-10.6,0-19.2,8.5-19.2,19s8.6,19,19.2,19s19.2-8.5,19.2-19S50.6,20.5,40,20.5z
                                               M40,52.5c-7,0-12.6-5.6-12.6-12.4S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"
                                    />
                                </g>

                                {{-- TAIL: SADECE BURASI OYNAR --}}
                                <g
                                    id="pinTail-{{ $this->getId() }}"
                                    clip-path="url(#pinTailClip)"
                                    style="transform-box: fill-box;transform-origin: 40px 58px;will-change: transform;"
                                >
                                    <path
                                        fill="url(#copperGrad)"
                                        d="M40,0C17.9,0,0,17.7,0,39.4S40,115,40,115s40-53.9,40-75.6S62.1,0,40,0z
                                               M40,52.5c-7,0-12.6-5.6-12.6-12.4S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"
                                    />
                                    <path
                                        fill="rgba(0,0,0,0.18)"
                                        d="M40,20.5c-10.6,0-19.2,8.5-19.2,19s8.6,19,19.2,19s19.2-8.5,19.2-19S50.6,20.5,40,20.5z
                                               M40,52.5c-7,0-12.6-5.6-12.6-12.4S33,27.7,40,27.7s12.6,5.6,12.6,12.4C52.6,46.9,47,52.5,40,52.5z"
                                    />
                                </g>
                            </svg>
                        </div>
                    </div>

                    {{-- WHEEL SVG --}}
                    <svg viewBox="0 0 1000 1000" class="absolute inset-0" aria-hidden="true">
                        <defs>
                            <!-- İç gölge (çok minimal) -->
                            <filter id="innerShadow">
                                <feOffset dx="0" dy="2"/>
                                <feGaussianBlur stdDeviation="4" result="blur"/>
                                <feComposite in="blur" in2="SourceAlpha" operator="out" result="shadow"/>
                                <feColorMatrix
                                    in="shadow"
                                    type="matrix"
                                    values="0 0 0 0 0
                                                0 0 0 0 0
                                                0 0 0 0 0
                                                0 0 0 .25 0"/>
                                <feComposite in2="SourceGraphic" operator="over"/>
                            </filter>

                            <!-- Dış gölge (alt kısım) -->
                            <filter id="dropShadowBottom" x="-20%" y="-20%" width="140%" height="160%">
                                <feOffset dx="0" dy="14"/>
                                <feGaussianBlur stdDeviation="18"/>
                                <feColorMatrix
                                    type="matrix"
                                    values="0 0 0 0 0
                                                0 0 0 0 0
                                                0 0 0 0 0
                                                0 0 0 .18 0"/>
                            </filter>

                            {{-- Slice gradientleri --}}
                            @for($i=0;$i<$n;$i++)
                                @php
                                    $g = $items[$i]['grad'] ?? null;
                                    $resolve = fn($v) => str_starts_with($v,'--') ? "var($v)" : $v;
                                @endphp

                                @if(is_array($g) && count($g) >= 2)
                                    <radialGradient id="sliceGrad-{{ $i }}"
                                                    cx="50%" cy="50%" r="90%"
                                                    fx="50%" fy="50%">
                                        <stop offset="0%" stop-color="{{ $resolve($g[0]) }}"/>
                                        <stop offset="100%" stop-color="{{ $resolve($g[1]) }}"/>
                                    </radialGradient>
                                @endif
                            @endfor
                        </defs>

                        {{-- Dış gölge --}}
                        <circle
                            cx="500" cy="500" r="440"
                            fill="none"
                            stroke="{{ $theme['rim_stroke'] ?? '#ffffff' }}"
                            stroke-width="20"
                            filter="url(#dropShadowBottom)"
                        />

                        {{-- Ana çember + iç gölge --}}
                        <circle
                            cx="500" cy="500" r="460"
                            fill="none"
                            stroke="{{ $theme['rim_stroke'] ?? '#ffffff' }}"
                            stroke-width="20"
                            filter="url(#innerShadow)"
                        />

                        {{-- Noktalar --}}
                        @php $dotCount = 18; @endphp
                        @for($i = 0; $i < $dotCount; $i++)
                            @php
                                $angle = deg2rad($i * (360 / $dotCount) - 90);
                                $radius = 460;
                                $x = 500 + cos($angle) * $radius;
                                $y = 500 + sin($angle) * $radius;
                            @endphp
                            <circle cx="{{ $x }}" cy="{{ $y }}" r="5" fill="{{ $theme['dot_color'] ?? '#000' }}"/>
                        @endfor

                        {{-- SLICES + TEXT --}}
                        <g id="wheelGroup-{{ $this->getId() }}" style="transform-origin: 500px 500px;">
                                <g id="wheelSlices-{{ $this->getId() }}" filter="url(#innerShadow)">
                                @for($i = 0; $i < $n; $i++)
                                    @php
                                        $a0 = $startAngle + ($i * $sliceDeg);
                                        $a1 = $a0 + $sliceDeg;
                                        $mid = $a0 + ($sliceDeg / 2);

                                        $path = $wedgePath($a0, $a1, $R);
                                        $g = $items[$i]['grad'] ?? null;

                                        $fallbackColor = $items[$i]['color'] ?? '#2a3a3c';
                                        $resolve = fn($v) => (is_string($v) && str_starts_with($v,'--')) ? "var($v)" : $v;

                                        $isGradient = is_array($g) && count($g) >= 2;
                                        $fill = $isGradient ? "url(#sliceGrad-{$i})" : $resolve($fallbackColor);

                                        [$tx, $ty] = $polar($mid, 310);

                                        $rot = $mid;
                                        if ($mid > 90 && $mid < 270) $rot = $mid + 180;

                                        $label = $items[$i]['label'] ?? '';
                                    @endphp

                                    <path d="{{ $path }}" fill="{{ $fill }}"></path>

                                    <path
                                        d="{{ $path }}"
                                        fill="none"
                                        stroke="{{ $theme['divider'] ?? 'rgba(255,255,255,0.14)' }}"
                                        stroke-width="2"
                                    ></path>

                                    <text
                                        x="{{ $tx }}" y="{{ $ty }}"
                                        fill="{{ $theme['text_fill'] ?? 'rgba(255,255,255,0.96)' }}"
                                        font-size="30"
                                        font-weight="700"
                                        text-anchor="middle"
                                        dominant-baseline="middle"
                                        transform="rotate({{ $rot }} {{ $tx }} {{ $ty }})"
                                        class=" text-[28px] lg:text-[23px] "
                                        style="letter-spacing:0.2px; paint-order:stroke; stroke:{{ $theme['text_stroke'] ?? 'rgba(0,0,0,0.18)' }}; stroke-width:2px;"
                                    >
                                        {{ $label }}
                                    </text>
                                @endfor
                            </g>
                        </g>

                        {{-- CENTER CAP (minimal: outer white r=32, inner copper r=22) --}}
                        <circle cx="500" cy="500" r="32" fill="{{ $theme['cap_outer'] ?? '#ffffff' }}" />
                        <circle cx="500" cy="500" r="22" fill="{{ $theme['cap_inner'] ?? '#2c7d6f' }}" />
                    </svg>
                </div>
            </div>

            {{-- FORM (RIGHT) --}}
            <div class="min-w-0 lg:col-span-6 lg:mt-2 md:-mt-5 ">
                @if(! $spinDone)
                    <div>

                        {{-- HEADER --}}
                        <p class="-mt-6 inline-flex items-center gap-3 text-[11px] font-semibold uppercase tracking-[0.3em] text-brand-600 lg:mt-0">
                            <span class="h-px w-8 bg-[#c9973f]"></span>{{ __('forms.lucky-spin.flip-to-win') }}
                        </p>

                        <h3 class="mt-4 text-[min(34px,calc((100vw_-_2rem)*0.09))] font-light leading-[1.15] tracking-[-0.015em] text-brand-900 sm:text-[40px] [&_strong]:font-semibold">
                            {!! __('forms.lucky-spin.title') !!}
                        </h3>
                        <p class="mt-3 max-w-md text-[15px] leading-relaxed text-main-500">
                            {{ __('forms.lucky-spin.form-info') }}
                        </p>


                        {{-- FORM --}}
                        <div class="mt-6 grid gap-5">
                            {{-- FULL NAME --}}
                            <div>
                                <label class="mb-1.5 block text-[10px] tracking-[0.15em] uppercase text-main-500">
                                    {{ __('forms.consultation.fields.name') }}
                                </label>

                                <x-input
                                    type="text"
                                    wire:model.live="name"
                                    autocomplete="name"
                                    :placeholder="__('forms.consultation.placeholders.name')"
                                    :class="'rounded-xl px-2.5 py-1.5 lg:px-3.5 lg:py-2.5 text-[14px] '.$field"
                                />


                                @error('name')
                                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- PHONE --}}
                            <div>
                                <label class="mb-2 block text-[11px] tracking-[0.24em] uppercase text-main-500">
                                    {{ __('forms.consultation.fields.phone') }}
                                </label>

                                @php($phoneId = 'phone-'.$this->getId())

                                <div wire:ignore class="w-full block"
                                     data-react-phone
                                     data-input-id="{{ $phoneId }}"
                                     data-hidden-target="{{ $phoneId }}_hidden"
                                     data-theme="light"
                                     data-placeholder="{{ __('forms.consultation.placeholders.phone') }}"
                                     data-search-placeholder="{{ __('forms.consultation.country_search') }}"
                                     data-country-label="{{ __('forms.consultation.country_label') }}"
                                     data-invalid-text="{{ __('validation.custom.phone.valid_phone') }}">
                                </div>


                                <input type="hidden" id="{{ $phoneId }}_hidden" wire:model.live="phone">

                                @error('phone')
                                <p class="mt-1 text-[12px] text-red-500">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- PRIVACY --}}
                        <div class="hidden mt-2.5 lg:flex items-center gap-2 text-[12px] text-main-500">
                            <i class="fa-solid fa-lock text-emerald-600 text-[13px]"></i>
                            {{ __('forms.consultation.privacy') }}
                        </div>
                    </div>

                    {{-- ACTION (x-button style like your submit) --}}
                    <div class="mt-0  pt-6 flex justify-start">
                        <x-button
                            type="button"
                            variant="primary"
                            wire:click="spin"
                            wire:loading.attr="disabled"
                            wire:target="spin"
                            class="pr-5 pl-6"
                        >
                            <span wire:loading.remove wire:target="spin">{{ __('forms.lucky-spin.spin-now') }}<span class="text-white/90">→</span></span>
                            <span wire:loading wire:target="spin">{{ __('forms.lucky-spin.spinning') }} <span class="text-white/90">→</span></span>
                        </x-button>
                    </div>
            </div>
            @endif

            {{-- RESULT --}}
            @if($spinDone && $result)
                <div
                    class="mt-6 rounded-3xl border border-main-200
           bg-gradient-to-br from-white/90 to-white/70
           px-6 py-6 text-center
           shadow-[0_20px_50px_rgba(0,0,0,0.08)] backdrop-blur"
                >
                    <!-- Başlık -->
                    <div class="flex items-center justify-center gap-2">
                        <span class="text-2xl">🎉</span>
                        <div class="text-lg font-medium text-main-900">
                            {{ __('forms.lucky-spin.congratulations') }}
                        </div>
                    </div>

                    <!-- Kazanılan ödül -->
                    <div class="mt-4 text-3xl font-light tracking-tight text-main-900">
                        {{ $result['label'] }}
                    </div>

                    <!-- Açıklama alanı -->
                    <div
                        class="mt-4 rounded-xl
               bg-main-50 px-4 py-3
               text-[14px] text-main-700"
                    >
                        {{ __('forms.lucky-spin.congratulations-desc') }}

                    </div>

                    <!-- Alt bilgi -->
                    <div class="mt-4 text-xs text-main-500">
                        {{ __('forms.lucky-spin.congratulations-info') }}
                    </div>
                </div>

            @endif
        </div>

    </div>
</div>

@once
    @push('styles')
        <style>
            /* Spin sırasında Safari performans: filter'ları kapat */
            [data-lucky-spin][data-spinning="1"] svg #innerShadow,
            [data-lucky-spin][data-spinning="1"] svg #dropShadowBottom { filter: none !important; }

            /* Asıl hedef: wheelSlices filter'ı ve dış stroke shadow */
            [data-lucky-spin][data-spinning="1"] g[id^="wheelSlices-"] { filter: none !important; }
            [data-lucky-spin][data-spinning="1"] circle[filter="url(#dropShadowBottom)"] { filter: none !important; }
            [data-lucky-spin][data-spinning="1"] circle[filter="url(#innerShadow)"] { filter: none !important; }

            /* İstersen text stroke da ağırsa spin sırasında azaltabilirsin */
            [data-lucky-spin][data-spinning="1"] text { paint-order: normal !important; stroke-width: 0 !important; }

        </style>
    @endpush
@endonce



@once
    @push('scripts')
        <script>
            (() => {
                // ✅ init kayıtları
                window.__luckySpinInited = window.__luckySpinInited || {};
                window.__luckySpinAngles = window.__luckySpinAngles || {};

                const IS_SAFARI = (() => {
                    const ua = navigator.userAgent || "";
                    return /Macintosh|iPhone|iPad|iPod/.test(ua)
                        && /Safari/.test(ua)
                        && !/Chrome|CriOS|FxiOS|EdgiOS|OPiOS|Android/.test(ua);
                })();

                function normalizeDeg(deg) {
                    deg = deg % 360;
                    return deg < 0 ? deg + 360 : deg;
                }

                function initInstance(instanceId, n) {
                    if (!instanceId) return;
                    if (window.__luckySpinInited[instanceId]) return; // ✅ bir kere kur
                    window.__luckySpinInited[instanceId] = true;

                    const slice = 360 / Math.max(1, n);

                    const dotCount = 18;
                    const step = 360 / dotCount;

                    let current = window.__luckySpinAngles[instanceId] || 0;
                    let isSpinning = false;

                    let rafId = null;
                    let lastBucket = null;
                    let lastTickAt = 0;

                    // ✅ Safari 30fps throttle (wheel)
                    let lastPaint = 0;

                    function getRoot() {
                        return document.querySelector(`[data-lucky-spin][data-instance-id="${instanceId}"]`);
                    }

                    function getWheel() {
                        return document.getElementById(`wheelGroup-${instanceId}`);
                    }

                    function getPinTail() {
                        return document.getElementById(`pinTail-${instanceId}`);
                    }

                    function applyAngle() {
                        const w = getWheel();
                        if (!w) return;
                        const angle = (window.__luckySpinAngles[instanceId] ?? current) || 0;
                        w.style.transition = "none";
                        w.style.transform = `rotate(${angle}deg)`;
                    }

                    // sayfa açılır açılmaz varsa bas
                    applyAngle();

                    // ✅ Safari pin anim (CSS transform)
                    function safariHitPin(tail) {
                        if (tail._pinRAF) cancelAnimationFrame(tail._pinRAF);

                        const ORIGIN_X = 40;
                        const ORIGIN_Y = 58;

                        tail.style.transformBox = "fill-box";
                        tail.style.transformOrigin = `${ORIGIN_X}px ${ORIGIN_Y}px`;
                        tail.style.willChange = "transform";

                        const start = performance.now();
                        const dur = 180;
                        const easeOut = (x) => 1 - Math.pow(1 - x, 3);

                        const MAX = 23;
                        const KICK = 0.8;

                        const keyDeg = (p) => {
                            if (p <= 0.55) return 0 + (MAX - 0) * (p / 0.55);
                            if (p <= 0.82) return MAX + (KICK - MAX) * ((p - 0.55) / 0.27);
                            return KICK + (0 - KICK) * ((p - 0.82) / 0.18);
                        };

                        const tick = (ts) => {
                            const p = Math.min(1, (ts - start) / dur);
                            const deg = keyDeg(easeOut(p));

                            tail.style.transform = `translateZ(0) rotate(${deg}deg)`;

                            if (p < 1) tail._pinRAF = requestAnimationFrame(tick);
                            else {
                                tail.style.transform = `translateZ(0) rotate(0deg)`;
                                tail._pinRAF = null;
                            }
                        };

                        tail._pinRAF = requestAnimationFrame(tick);
                    }

                    function hitPin() {
                        const tail = getPinTail();
                        if (!tail) return;

                        // overlap lock (pin üst üste binmesin)
                        const now = performance.now();
                        if (tail._busyUntil && now < tail._busyUntil) return;

                        // ✅ Safari: daha uzun lock → daha az pin spam → daha az kasma
                        tail._busyUntil = now + (IS_SAFARI ? 220 : 110);

                        if (IS_SAFARI) {
                            safariHitPin(tail);
                            return;
                        }

                        if (tail._pinAnim) tail._pinAnim.cancel();

                        tail._pinAnim = tail.animate(
                            [
                                { transform: "rotate(0deg)", offset: 0 },
                                { transform: "rotate(16deg)", offset: 0.5 },
                                { transform: "rotate(2deg)", offset: 0.78 },
                                { transform: "rotate(0deg)", offset: 1 },
                            ],
                            {
                                duration: 240,
                                easing: "cubic-bezier(.16, 1, .3, 1)",
                                fill: "none",
                            }
                        );
                    }

                    function startTickLoop() {
                        stopTickLoop();
                        lastBucket = null;
                        lastTickAt = 0;

                        const loop = () => {
                            // ✅ Safari: tick loop’u her frame işletme (hafif kasmayı keser)
                            if (IS_SAFARI) {
                                const now = performance.now();
                                if (now - lastTickAt < 60) {
                                    rafId = requestAnimationFrame(loop);
                                    return;
                                }
                            }

                            const angle = normalizeDeg(current);
                            const bucket = Math.floor(angle / step);

                            if (lastBucket === null) lastBucket = bucket;

                            if (bucket !== lastBucket) {
                                const now = performance.now();

                                // ✅ Safari: pin daha seyrek vursun
                                const cd = IS_SAFARI ? 130 : 55;

                                if (now - lastTickAt > cd) {
                                    hitPin();
                                    lastTickAt = now;
                                }
                                lastBucket = bucket;
                            }

                            rafId = requestAnimationFrame(loop);
                        };

                        rafId = requestAnimationFrame(loop);
                    }

                    function stopTickLoop() {
                        if (rafId) cancelAnimationFrame(rafId);
                        rafId = null;
                    }

                    function spinToIndex(index) {
                        if (isSpinning) return;

                        const w0 = getWheel();
                        if (!w0) return;

                        isSpinning = true;
                        startTickLoop();

                        // ✅ spin başlarken root flag (CSS ile filter kapatmak için)
                        const root = getRoot();
                        if (root) root.setAttribute("data-spinning", "1");

                        const target = normalizeDeg(360 - ((index + 0.5) * slice));
                        const currentMod = normalizeDeg(current);

                        let delta = target - currentMod;
                        delta = normalizeDeg(delta);

                        const extraTurns = IS_SAFARI
                            ? (4 + Math.floor(Math.random() * 2))
                            : (6 + Math.floor(Math.random() * 2));

                        const jitter = (Math.random() - 0.5) * (slice * 0.06);
                        const total = extraTurns * 360 + delta + jitter;

                        const duration = IS_SAFARI ? 4200 : 5200;
                        const start = performance.now();
                        const from = current;
                        const to = current + total;

                        const easeOutCubic = (t) => 1 - Math.pow(1 - t, 3);

                        function animate(now) {
                            const w = getWheel();
                            if (!w) {
                                stopTickLoop();
                                isSpinning = false;
                                const root = getRoot();
                                if (root) root.setAttribute("data-spinning", "0");
                                return;
                            }

                            const t = Math.min(1, (now - start) / duration);
                            const eased = easeOutCubic(t);

                            current = from + (to - from) * eased;
                            window.__luckySpinAngles[instanceId] = current;

                            // ✅ Safari 30fps throttle
                            if (IS_SAFARI) {
                                if (now - lastPaint >= 33 || t >= 1) {
                                    w.style.transform = `rotate(${current}deg)`;
                                    lastPaint = now;
                                }
                            } else {
                                w.style.transform = `rotate(${current}deg)`;
                            }

                            if (t < 1) {
                                requestAnimationFrame(animate);
                            } else {
                                stopTickLoop();
                                isSpinning = false;

                                window.__luckySpinAngles[instanceId] = current;
                                applyAngle();

                                const root = getRoot();
                                if (root) root.setAttribute("data-spinning", "0");

                                if (window.Livewire) {
                                    window.Livewire.dispatch("spinDone", { sourceId: instanceId });
                                }
                            }
                        }

                        w0.style.transition = "none";
                        requestAnimationFrame(animate);
                    }

                    // ✅ bu instance için spinResult yakala
                    window.addEventListener("spinResult", (e) => {
                        const { index, sourceId } = e.detail || {};
                        if (sourceId && sourceId !== instanceId) return;
                        spinToIndex(Number(index || 0));
                    });

                    // Livewire DOM güncelleyince angle bas
                    document.addEventListener("livewire:navigated", applyAngle);

                    if (window.Livewire) {
                        window.Livewire.hook("message.processed", () => {
                            applyAngle();
                        });
                    }


                }

                // ✅ sayfadaki tüm lucky spin’leri bulup init et
                function scanAndInit() {
                    document.querySelectorAll("[data-lucky-spin]").forEach((el) => {
                        const instanceId = el.getAttribute("data-instance-id");
                        const n = Number(el.getAttribute("data-slice-count") || 1);
                        initInstance(instanceId, n);
                    });
                }

                // ilk yük
                scanAndInit();

                // Livewire her render sonrası tekrar tara
                document.addEventListener("livewire:navigated", scanAndInit);
                if (window.Livewire) {
                    window.Livewire.hook("message.processed", scanAndInit);
                }
            })();
        </script>




        @endpush
        @endonce


        </div>
