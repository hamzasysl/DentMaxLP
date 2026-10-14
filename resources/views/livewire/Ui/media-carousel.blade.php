<div
    x-data="mediaCarousel({
        items: @js(collect($items)->map(fn($it) => [
            'type'     => $it['type'] ?? 'image',
            'poster'   => isset($it['poster']) ? asset($it['poster']) : null,
            'src'      => isset($it['src']) ? asset($it['src']) : null,
            'provider' => $it['provider'] ?? null,
            'id'       => $it['id'] ?? null,
            'aspect'   => $it['aspect'] ?? (($it['type'] ?? 'image') === 'video' ? '9/16' : null),
        ])->values())
    })"
    x-init="init()"
    @keydown.escape.window="close()"
>
    <!-- viewport -->
    <div
        class="relative h-[600px] sm:h-[680px] lg:h-[660px] select-none touch-pan-y"
        @pointerdown="dragStart($event)"
        @pointermove.window="dragMove($event)"
        @pointerup.window="dragEnd($event)"
        @pointercancel.window="dragEnd($event)"
    >
        <!-- slides -->
        <div class="absolute inset-0 pointer-events-none">
            <template x-for="(item, i) in items" :key="(item.src || '') + '-' + i">
                <button
                    type="button"
                    class="focus:outline-none"
                    :class="cardClassByIndex(i) + (isActive(i)
        ? ' cursor-pointer pointer-events-auto'
        : ' cursor-default pointer-events-none')"
                    :disabled="!isActive(i)"
                    @click.stop.prevent="openItem(item)"
                >

                <div class="relative h-full w-full overflow-hidden rounded-[1.75rem]">
                        <img
                            :src="item.poster || item.src"
                            alt="Media"
                            class="h-full w-full object-cover pointer-events-none select-none"
                            draggable="false"
                            @dragstart.prevent
                        />

                        <div class="absolute inset-0"
                             :class="isActive(i)
                                ? 'bg-gradient-to-tr from-main-900/45 via-main-800/10 to-transparent'
                                : 'bg-gradient-to-tr from-main-900/55 via-main-800/20 to-transparent'">
                        </div>

                        <!-- play (sadece video/embed) -->
                        <template x-if="item.type === 'video' || item.type === 'embed'">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="inline-flex h-14 w-14 items-center justify-center rounded-full
                                             bg-white/55 backdrop-blur border border-white/70
                                             transition-transform duration-200"
                                      :class="isActive(i) ? 'scale-100' : 'scale-95'">
                                    <svg class="h-6 w-6 text-brand-600 ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </span>
                            </div>
                        </template>
                    </div>
                </button>
            </template>
        </div>

        <!-- arrows -->
        <button
            type="button"
            class="absolute cursor-pointer left-0 sm:left-1 top-1/2 -translate-y-1/2 z-[70]
                   p-2 rounded-full text-main-900/60 hover:text-brand-600 hover:scale-109 transition select-none"
            @click.stop="prev()"
            aria-label="Previous"
        >
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                <path d="M14.5 5.5L8 12l6.5 6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <button
            type="button"
            class="absolute  cursor-pointer right-0 sm:right-1 top-1/2 -translate-y-1/2 z-[70]
                   p-2 rounded-full text-main-900/60 hover:text-brand-600 hover:scale-109 transition select-none"
            @click.stop="next()"
            aria-label="Next"
        >
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none">
                <path d="M9.5 5.5L16 12l-6.5 6.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>
    </div>

    <!-- ✅ POPUP (teleport -> body) -->
    <template x-teleport="body">
        <div
            x-show="open"
            x-transition.opacity.duration.200ms
            class="fixed inset-0 z-[2147483647] isolate flex items-center justify-center bg-black/75 p-4 sm:p-6"
            style="display:none; transform: translateZ(0); -webkit-transform: translateZ(0);"
            @click.self="close()"
            @touchend.self.prevent="close()"
            @touchmove.prevent
            @wheel.prevent
        >
            <!-- blur (iOS stacking fix) -->
            <div class="absolute inset-0 supports-[backdrop-filter]:backdrop-blur-sm"></div>

            <!-- ✅ MOBILE: X yok, yardım metni top-safe-area (iOS Safari ortada kalma fix) -->
            <div
                class="sm:hidden fixed left-1/2 -translate-x-1/2 z-[2147483647] pointer-events-none top-6">
                <div class="px-4 py-2 text-white/85 text-[14px] w-max leading-none drop-shadow-[0_2px_6px_rgba(0,0,0,0.65)]">
                    {{__('front.global.space-bar-to-close')}}
                </div>
            </div>

            <!-- ✅ DESKTOP: box -->
            <div
                @click.outside="close()"
                class="relative rounded-2xl overflow-hidden bg-black max-h-[65vh] sm:max-h-[85vh]"
                :style="popupBoxStyle()"
                style="transform: translateZ(0); -webkit-transform: translateZ(0);"
                @pointerdown.stop
                @pointerup.stop
                @pointermove.stop
            >
                <!-- ✅ DESKTOP CLOSE (sm+) — kutunun içinde, sağ üst -->
                <button
                    type="button"
                    @click.stop="close()"
                    class="hidden sm:inline-flex absolute right-4 top-4 z-[120]
                           h-10 w-10 items-center justify-center cursor-pointer
                           rounded-full bg-black/60 text-white/90 text-2xl font-light
                           hover:bg-white/10 transition"
                    aria-label="Close"
                >
                    <span class="leading-none -translate-y-px select-none">×</span>
                </button>

                <!-- 🖼️ POSTER OVERLAY -->
                <img
                    x-show="open && !mediaReady && (current?.poster || current?.src)"
                    :src="current?.poster || current?.src"
                    alt="Poster"
                    class="absolute inset-0 z-10 h-full w-full object-cover"
                    style="display:none;"
                />
                <div
                    x-show="open && !mediaReady"
                    class="absolute inset-0 z-10 bg-black/30"
                    style="display:none;"
                ></div>

                <!-- 🔵 LOCAL MP4 VIDEO -->
                <video
                    x-show="open && current?.type === 'video'"
                    x-ref="popupVideo"
                    controls
                    playsinline
                    preload="auto"
                    class="relative z-20 h-full w-full"
                    :class="current?.aspect === '9/16' ? 'object-contain' : 'object-cover'"
                    style="display:none;"
                    @loadeddata="mediaReady = true"
                    @canplay="mediaReady = true"
                >
                    <source :src="videoSrc" type="video/mp4">
                </video>

                <!-- 🔴 YOUTUBE / VIMEO EMBED -->
                <iframe
                    x-show="open && current?.type === 'embed'"
                    :src="embedSrc"
                    class="relative z-20 h-full w-full"
                    style="display:none;"
                    frameborder="0"
                    allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen
                    @load="mediaReady = true"
                ></iframe>

                <!-- 🟢 IMAGE -->
                <img
                    x-show="open && current?.type === 'image'"
                    :src="current?.src"
                    alt="Image"
                    class="relative z-20 h-full w-full object-contain"
                    draggable="false"
                    @dragstart.prevent
                    style="display:none;"
                />
            </div>
        </div>
    </template>


    @once
        @push('styles')

        @endpush

        @push('scripts')
            <script>
                document.addEventListener('alpine:init', () => {
                    window.mediaCarousel = ({ items }) => ({
                        items: Array.isArray(items) ? items : [],
                        active: 0,
                        open: false,
                        current: null,

                        // ✅ local mp4
                        videoSrc: null,

                        // ✅ youtube / vimeo
                        embedSrc: null,

                        // ✅ popup açılırken siyah flash engeli
                        mediaReady: false,

                        drag: { down:false, id:null, startX:0, startY:0, lastX:0, lastY:0, moved:false, cancelClick:false },

                        init() {},

                        clamp(i) {
                            const n = this.items.length;
                            if (!n) return 0;
                            return (i % n + n) % n;
                        },
                        prev() { this.active = this.clamp(this.active - 1); },
                        next() { this.active = this.clamp(this.active + 1); },

                        isActive(i) { return i === this.active; },
                        isPrev(i)   { return i === this.clamp(this.active - 1); },
                        isNext(i)   { return i === this.clamp(this.active + 1); },

                        cardClassByIndex(i) {
                            const base = "pointer-events-auto absolute top-1/2 -translate-y-1/2 transition-all duration-300 ease-out";
                            if (!this.isActive(i) && !this.isPrev(i) && !this.isNext(i)) {
                                return `${base} opacity-0 scale-75 pointer-events-none`;
                            }
                            const size = "h-[82%] sm:h-[84%] lg:h-[86%] w-[68%] sm:w-[60%] lg:w-[58%]";
                            if (this.isActive(i)) return `${base} ${size} z-30 left-[50%] -translate-x-1/2 opacity-100 scale-100`;
                            if (this.isPrev(i))   return `${base} ${size} z-20 left-[6%] opacity-40 scale-90 blur-[0.5px]`;
                            return `${base} ${size} z-20 right-[6%] opacity-40 scale-90 blur-[0.5px]`;
                        },

                        popupBoxStyle() {
                            const maxH = "85vh";
                            if (this.current?.type === "video" || this.current?.type === "embed") {
                                const a = this.current?.aspect || "9/16";
                                if (a === "9/16") return `aspect-ratio: 9 / 16; width: min(76vw, 420px); max-height: ${maxH};`;
                                if (a === "1/1")  return `aspect-ratio: 1 / 1; width: min(92vw, 720px); max-height: ${maxH};`;
                                return `aspect-ratio: 16 / 9; width: min(92vw, 960px); max-height: ${maxH};`;
                            }
                            return `width: min(92vw, 960px); max-height: ${maxH};`;
                        },

                        dragStart(e) {
                            if (e.pointerType === 'mouse' && e.button !== 0) return;

                            this.drag.down = true;
                            this.drag.id = e.pointerId ?? null;

                            this.drag.startX = e.clientX;
                            this.drag.startY = e.clientY;
                            this.drag.lastX  = e.clientX;
                            this.drag.lastY  = e.clientY;

                            this.drag.moved = false;
                            this.drag.cancelClick = false;
                        },


                        dragMove(e) {
                            if (!this.drag.down) return;
                            if (this.drag.id != null && e.pointerId != null && e.pointerId !== this.drag.id) return;

                            this.drag.lastX = e.clientX;
                            this.drag.lastY = e.clientY;

                            const dx = this.drag.lastX - this.drag.startX;

                            // drag başladı say (swipe hissi)
                            const MOVE = (e.pointerType === 'mouse') ? 4 : 2;
                            if (!this.drag.moved && Math.abs(dx) > MOVE) {
                                this.drag.moved = true;
                            }
                        },


                        dragEnd(e) {
                            if (!this.drag.down) return;
                            if (this.drag.id != null && e.pointerId != null && e.pointerId !== this.drag.id) return;

                            const dx = this.drag.lastX - this.drag.startX;
                            const dy = this.drag.lastY - this.drag.startY;

                            this.drag.down = false;
                            this.drag.id = null;

                            // ✅ EN KRİTİK: çok hafif kayma bile varsa click iptal
                            // tap jitter’ı ayırmak için "yatay baskın" kontrolü
                            const CLICK_CANCEL = (e.pointerType === 'mouse') ? 4 : 2; // 2px bile iptal
                            if (Math.abs(dx) > CLICK_CANCEL && Math.abs(dx) >= Math.abs(dy)) {
                                this.drag.cancelClick = true;
                            }

                            // ✅ hafif kaydırınca da slide değişsin
                            const TH = (e.pointerType === 'mouse') ? 28 : 16;
                            if (dx > TH) this.prev();
                            else if (dx < -TH) this.next();
                        },



                        openItem(item, force = false) {
                            if (!force && this.drag.cancelClick) {
                                this.drag.cancelClick = false;
                                return;
                            }
                            this.drag.cancelClick = false;

                            this.current = item;
                            this.open = true;
                            this.mediaReady = false;

                            this.videoSrc = (item?.type === 'video') ? item.src : null;
                            this.embedSrc = (item?.type === 'embed')
                                ? this.makeEmbedUrl(item)
                                : null;

                            this.$nextTick(() => {
                                if (item?.type !== 'video') return;
                                const v = this.$refs.popupVideo;
                                if (!v) return;
                                v.load();
                                const p = v.play?.();
                                if (p?.catch) p.catch(() => {});
                            });
                        },

                        makeEmbedUrl(item) {
                            if (item.provider === 'youtube') {
                                return `https://www.youtube-nocookie.com/embed/${item.id}?autoplay=1&playsinline=1&rel=0`;
                            }
                            if (item.provider === 'vimeo') {
                                return `https://player.vimeo.com/video/${item.id}?autoplay=1`;
                            }
                            return null;
                        },

                        close() {
                            const v = this.$refs.popupVideo;
                            if (v) { v.pause(); v.currentTime = 0; }

                            this.open = false;
                            setTimeout(() => {
                                this.current = null;
                                this.videoSrc = null;
                                this.embedSrc = null;
                                this.mediaReady = false;
                            }, 220);
                        },
                    });
                });
            </script>
        @endpush
    @endonce
</div>
