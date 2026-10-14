<div>
    <section id="google-reviews" class="relative overflow-hidden bg-white py-14 lg:py-20">

        <div class="mx-auto max-w-screen-2xl px-6 lg:px-10">

            <!-- header -->
            <div class="flex flex-col pt-15 gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
                    <p class="text-[12px] tracking-[0.28em] uppercase text-main-400">
                        {{ __('front.reviews.google-reviews') }}
                    </p>
                    <h2 class="mt-2 text-4xl sm:text-3xl leading-[1.3] lg:text-4xl font-extralight text-main-900 tracking-tight">
                        {{ __('front.reviews.title') }}
                    </h2>
                    <p class="mt-3 text-sm sm:text-[15px] font-light text-main-600">
                        {{ __('front.reviews.desc') }}
                    </p>
                </div>

                <!-- rating pill -->
                <div class="w-fit sm:w-auto inline-flex items-center justify-between sm:justify-start gap-3 rounded-full border border-main-200/70 bg-white/70 backdrop-blur px-4 py-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white shrink-0">
                        <svg viewBox="0 0 48 48" class="h-5 w-5">
                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.236 32.659 29.02 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.957 3.043l5.657-5.657C34.047 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 16.108 18.961 12 24 12c3.059 0 5.842 1.154 7.957 3.043l5.657-5.657C34.047 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                            <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.197l-6.191-5.238C29.236 35.091 26.747 36 24 36c-4.999 0-9.205-3.324-10.685-7.955l-6.522 5.025C9.993 39.556 16.457 44 24 44z"/>
                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.07 12.07 0 0 1-4.085 5.565l.003-.002 6.191 5.238C36.971 40.205 44 36 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                        </svg>
                    </span>

                    @php
                        $filled = (int) floor($avg);
                        $hasHalf = ($avg - $filled) >= 0.5;
                        $coppers = ['text-brand-100','text-brand-200','text-brand-300','text-brand-400','text-brand-600'];
                    @endphp

                    <div class="flex items-center gap-2 min-w-0">
                        <div class="flex items-center gap-1 shrink-0">
                            @for($s=1; $s<=5; $s++)
                                @php
                                    $isFilled = $s <= $filled || ($hasHalf && $s === $filled + 1);
                                    $cls = $isFilled ? ($coppers[$s-1] ?? 'text-brand-400') : 'text-main-200';
                                @endphp
                                <svg viewBox="0 0 24 24" class="h-4 w-4 {{ $cls }} fill-current">
                                    <path d="M12 17.27 18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            @endfor
                        </div>

                        <span class="text-sm font-medium text-main-800 shrink-0">{{ number_format($avg, 1) }}</span>
                        <span class="text-xs text-main-500 shrink-0">•</span>
                        <span class="text-xs text-main-500 truncate">{{ $total }}</span>
                    </div>
                </div>
            </div>

            <!-- marquee -->
            <div
                class="relative mt-10 marquee"
                x-data="{
                    track:null,
                    x:0,
                    startX:0,
                    startTranslate:0,
                    dragging:false,
                    dur: {{ (int) $duration }},
                    shiftPx:0,

                    init(){
                        this.track = this.$refs.track;
                        requestAnimationFrame(() => {
                            this.shiftPx = this.track.scrollWidth / {{ (int) $repeat }};
                        });
                    },

                    currentX(){
                        const tr = getComputedStyle(this.track).transform;
                        if (!tr || tr === 'none') return this.x;
                        const m = tr.match(/matrix.*\((.+)\)/);
                        return m ? parseFloat(m[1].split(',')[4]) : this.x;
                    },

                    setX(v){
                        if (this.shiftPx > 0){
                            while (v <= -this.shiftPx) v += this.shiftPx;
                            while (v > 0) v -= this.shiftPx;
                        }
                        this.x = v;
                        this.track.style.transform = `translate3d(${v}px,0,0)`;
                    },

                    down(e){
                        this.dragging = true;
                        this.track.classList.add('is-dragging');

                        const now = this.currentX();
                        this.track.style.animation = 'none';
                        this.setX(now);

                        this.startX = e.clientX;
                        this.startTranslate = this.x;
                    },

                    move(e){
                        if (!this.dragging) return;
                        this.setX(this.startTranslate + (e.clientX - this.startX));
                    },

                    up(){
                        if (!this.dragging) return;
                        this.dragging = false;
                        this.track.classList.remove('is-dragging');

                        const progress = (this.shiftPx > 0) ? (-this.x / this.shiftPx) : 0;
                        const delay = -(progress * this.dur);

                        this.track.style.transform = '';
                        this.track.style.animation = `marquee-left ${this.dur}s linear infinite`;
                        this.track.style.animationDelay = `${delay}s`;
                    },
                }"
            >
                <div class="pointer-events-none md:block absolute inset-y-0 left-0 w-14 sm:w-30 bg-gradient-to-r from-white via-white/90 to-transparent z-10"></div>
                <div class="pointer-events-none md:block absolute inset-y-0 right-0 w-14 sm:w-30 bg-gradient-to-l from-white via-white/90 to-transparent z-10"></div>

                <div
                    x-ref="track"
                    class="marquee__track"
                    style="--marquee-duration: {{ $duration }}s; --marquee-duration-mobile: {{ max(12, (int)($duration * 0.7)) }}s;"
                    @pointerdown.prevent="down($event)"
                    @pointermove.prevent="move($event)"
                    @pointerup="up()"
                    @pointerleave="up()"
                    @pointercancel="up()"
                >
                    @for($set=1; $set<=$repeat; $set++)
                        @foreach($reviews as $r)
                            @php
                                $stars = $this->starShadeByReviewCount((int)($r['review_count'] ?? 0));
                                $rating = (int)($r['rating'] ?? 5);
                            @endphp

                            <article class="review-card w-[320px] sm:w-[360px] rounded-3xl border border-main-200/70 bg-white/55 backdrop-blur-md px-6 py-6">
                                <div class="flex items-start gap-4">
                                    <div class="h-12 w-12 shrink-0 rounded-full bg-gradient-to-b from-brand-500 to-brand-400 text-white flex items-center justify-center font-semibold">
                                        {{ $this->initials($r['name'] ?? 'A') }}
                                    </div>

                                    <div class="min-w-0">
                                        <div class="flex items-center justify-between gap-3">
                                            <p class="text-base font-light text-main-900 truncate">
                                                {{ $r['name'] ?? 'Anonymous' }}
                                            </p>
                                        </div>
                                        <span class="text-[11px] tracking-[0.18em] uppercase text-main-500">
                                            {{ __('front.reviews.verified') }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-5 review-fade text-sm leading-relaxed font-light text-main-700">
                                    {{ $r['text'] ?? '' }}
                                </div>

                                <div class="mt-5 flex items-center justify-between text-xs text-main-500">
                                    <span class="text-brand-700/80">{{ __('front.reviews.read-more') }}</span>
                                    <span>{{ (int)($r['review_count'] ?? 0) }} {{ __('front.reviews.reviews') }}</span>
                                </div>
                            </article>
                        @endforeach
                    @endfor
                </div>
            </div>


            <!-- Footer -->
            <div class="flex flex-col pt-15 gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-2xl">
            <div>
                <x-button variant="primary"
                          onclick="Livewire.dispatch('open-book-consultation')">
                    {{ __('front.global.free-consultation') }}
                </x-button>
            </div>
                </div>
            </div>

        </div>
    </section>
@once
    @push('styles')
        <style>
            .marquee { overflow: hidden; touch-action: pan-x; }
            .marquee__track{
                width: max-content;
                display:flex;
                gap:1.25rem;
                will-change: transform;
                transform: translate3d(0,0,0);
                animation: marquee-left var(--marquee-duration, 46s) linear infinite;
                cursor: grab;
                user-select: none;
            }
            .marquee__track.is-dragging { cursor: grabbing; }

            @media (max-width: 767px){
                .marquee__track{
                    animation-duration: var(--marquee-duration-mobile, 32s);
                }
            }

            @keyframes marquee-left{
                0%   { transform: translate3d(0,0,0); }
                100% { transform: translate3d(calc(-1 * var(--marquee-shift, 50%)),0,0); }
            }

            .marquee:hover .marquee__track { animation-play-state: paused; }

            .review-card { flex: 0 0 auto; }

            .review-fade{
                line-height:1.75;
                overflow:hidden;

                max-height: 7em;
                -webkit-mask-image: linear-gradient(#000 78%, transparent);
                mask-image: linear-gradient(#000 78%, transparent);

                transition: max-height .45s ease, -webkit-mask-image .25s ease, mask-image .25s ease;
            }

            .review-card:hover .review-fade{
                max-height: 40em; /* ✅ gerçekçi bir limit */
                -webkit-mask-image:none;
                mask-image:none;
            }

        </style>
    @endpush
    @endonce
</div>
