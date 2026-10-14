{{-- resources/views/livewire/ui/our-doctors.blade.php --}}

<section id="our-doctors" class="relative bg-gradient-to-b from-white via-main-50/40 to-white py-16 lg:py-24 overflow-hidden">

    <!-- luxe hairlines -->
    <div class="pointer-events-none absolute left-1/2 top-16 h-px w-[140vw] -translate-x-1/2
        bg-gradient-to-r from-transparent via-brand-400/25 to-transparent opacity-70"></div>
    <div class="pointer-events-none absolute left-1/2 top-44 h-px w-[120vw] -translate-x-1/2 rotate-[4deg]
        bg-gradient-to-r from-transparent via-main-300/35 to-transparent opacity-60"></div>

    <!-- soft corner glow -->
    <div class="pointer-events-none absolute -top-56 -right-56 h-[520px] w-[520px] rounded-full blur-3xl bg-brand-200/20"></div>
    <div class="pointer-events-none absolute -bottom-56 -left-56 h-[520px] w-[520px] rounded-full blur-3xl bg-brand-100/25"></div>

    <div class="relative mx-auto max-w-screen-2xl px-6 lg:px-10 overflow-visible">

        <!-- HEADER -->
        <div class="grid gap-8 mt-5 lg:grid-cols-12 lg:items-end">
            <div class="lg:col-span-8">

                <h2 class="mt-4 text-4xl sm:text-4xl lg:text-5xl font-extralight text-brand-600 leading-[1.1]">
                {{ __('front.global.ourdoctor-head') }}
                    <span class="block mt-3 text-gray-600  text-[15px] md:text-[17px] font-extralight">
                        {{ __('front.global.ourdoctor-text') }}
                    </span>
                </h2>
            </div>

            <div class="hidden mb-2 md:block lg:col-span-4 lg:text-right">
                <x-button variant="primary"
                          onclick="Livewire.dispatch('open-book-consultation')">
                    {{ __('front.global.book-consultation') }}
                </x-button>
            </div>
        </div>

        @php
            $items = $items ?? [];
            $count = count($items);
            $getDesc = fn($doc) => $doc['description'] ?? ($doc['short'] ?? '');
            $hideArrowsOnDesktop = $count <= 3;
        @endphp

            <!-- SLIDER (always) -->
        <div class="mt-10 mr-2 ml-2 md:mr-0 md:ml-0 lg:mt-14"
             x-data="{
  dragging: false,
  pointerId: null,
  startX: 0,
  startScrollLeft: 0,
  startY: 0,
  hasLockedAxis: false,
  lock: null, // 'x' | 'y'
  moved: 0,

  // Hassasiyet:
  threshold: 14, // px (bunu düşürürsen daha az hareketle 1 kart atar)
  cardStep(){
    const el = this.$refs.rail;
    const card = el?.querySelector('[data-card]');
    if(!el || !card) return 0;
    const gap = 24; // gap-6
    return card.getBoundingClientRect().width + gap;
  },

  snapToIndex(idx){
    const el = this.$refs.rail;
    const step = this.cardStep();
    if(!el || !step) return;

    const max = el.scrollWidth - el.clientWidth;
    const target = Math.max(0, Math.min(max, idx * step));
    el.scrollTo({ left: target, behavior:'smooth' });
  },

  currentIndex(){
    const el = this.$refs.rail;
    const step = this.cardStep();
    if(!el || !step) return 0;
    return Math.round(el.scrollLeft / step);
  },

  next(){
    this.snapToIndex(this.currentIndex() + 1);
  },
  prev(){
    this.snapToIndex(this.currentIndex() - 1);
  },

  onDown(e){

  // drag sırasında snap + smooth kapansın (mobil tık/jitter biter)
el.style.scrollSnapType = 'none';
el.style.scrollBehavior = 'auto';

    const el = this.$refs.rail;
    if(!el) return;
    if (e.pointerType === 'mouse' && e.button !== 0) return;

    this.dragging = true;
    this.pointerId = e.pointerId;

    this.startX = e.clientX;
    this.startY = e.clientY;
    this.startScrollLeft = el.scrollLeft;

    this.hasLockedAxis = false;
    this.lock = null;
    this.moved = 0;

    // drag hissi
    el.classList.add('is-dragging');

    try { el.setPointerCapture(e.pointerId); } catch (err) {}
  },

  onMove(e){
    if(!this.dragging) return;
    const el = this.$refs.rail;
    if(!el) return;

    const dx = e.clientX - this.startX;
    const dy = e.clientY - this.startY;

    // Mobilde sapıtmayı engellemek için eksen kilidi:
    if(!this.hasLockedAxis){
      if (Math.abs(dx) + Math.abs(dy) < 6) return; // çok küçükse hiç karar verme
      this.lock = (Math.abs(dx) > Math.abs(dy)) ? 'x' : 'y';
      this.hasLockedAxis = true;
    }

    // Eğer kullanıcı dikey scroll istiyorsa: rail’i hiç elleme (sayfa scroll etsin)
    if(this.lock === 'y'){
      return;
    }

    // X kilitliysek: sayfanın sağ-sol “kayma” hissi olsun diye hafif scrollLeft uygula (optional)
    // ama jitter yapmasın diye küçük çarpan:
    el.scrollLeft = this.startScrollLeft - dx * 0.9;

    this.moved = dx;

    // X drag yaparken sayfanın seçilmesini engelle
    e.preventDefault();
  },

  onUp(){

  // bırakınca tekrar aktif et
el.style.scrollSnapType = 'x mandatory';
el.style.scrollBehavior = 'smooth';
    const el = this.$refs.rail;
    if(!el) return;

    this.dragging = false;

    try {
      if (this.pointerId !== null) el.releasePointerCapture(this.pointerId);
    } catch (err) {}

    this.pointerId = null;
    el.classList.remove('is-dragging');

    // Eğer y eksenine kilitlendiysek, hiçbir şey yapma (sayfa scroll’a izin verdik)
    if(this.lock === 'y') return;

    // Snap-by-card: küçük hareket bile 1 kart atsın
    const idx = this.currentIndex();

    if (this.moved <= -this.threshold) {
      // sola sürük = ileri (sağa kaydır)
      this.snapToIndex(idx + 1);
    } else if (this.moved >= this.threshold) {
      // sağa sürük = geri (sola kaydır)
      this.snapToIndex(idx - 1);
    } else {
      // eşik altı: bulunduğu karta geri otur
      this.snapToIndex(idx);
    }
  },
}"
        >

            <div class="relative overflow-visible">

                {{-- ARROWS
                     - mobilde kalsın (count>1)
                     - desktop'ta 3 ve altıysa gizle --}}
                @if($count > 1)
                    <button type="button"
                            x-on:click="prev()"
                            class="absolute cursor-pointer left-[-35px] md:left-[-40px] top-1/2 -translate-y-1/2 z-30 pointer-events-auto
                                   inline-flex h-11 w-11 items-center justify-center
                                   text-brand-400 hover:text-brand-600 transition
                                   {{ $hideArrowsOnDesktop ? 'xl:hidden' : '' }}">
                        <span class="text-[32px] font-extralight leading-none">‹</span>
                    </button>

                    <button type="button"
                            x-on:click="next()"
                            class="absolute cursor-pointer right-[-35px] md:right-[-40px] top-1/2 -translate-y-1/2 z-30 pointer-events-auto
                                   inline-flex h-11 w-11 items-center justify-center
                                   text-brand-400 hover:text-brand-600 transition
                                   {{ $hideArrowsOnDesktop ? 'xl:hidden' : '' }}">
                        <span class="text-[32px] font-extralight leading-none">›</span>
                    </button>
                @endif

                <!-- rail -->
                <div x-ref="rail"
                     @pointerdown="onDown($event)"
                     @pointermove="onMove($event)"
                     @pointerup="onUp()"
                     @pointercancel="onUp()"
                     class="flex items-stretch gap-6 overflow-x-auto pb-2
[scrollbar-width:none] [-ms-overflow-style:none]
snap-x snap-mandatory  select-none"
                     style="scrollbar-width:none; touch-action: pan-y; -webkit-overflow-scrolling: touch;"
                >

                    <style>
                        #our-doctors [x-ref="rail"]::-webkit-scrollbar { display:none; }
                        #our-doctors [x-ref="rail"].is-dragging { cursor: grabbing; }
                        #our-doctors [x-ref="rail"].is-dragging * { user-select:none; }
                        #our-doctors .doc-desc { scrollbar-width:none; }
                        #our-doctors .doc-desc::-webkit-scrollbar { display:none; }
                        #our-doctors [x-ref="rail"]::-webkit-scrollbar { display:none; }
                        #our-doctors [x-ref="rail"].is-dragging { cursor: grabbing; }
                        #our-doctors [x-ref="rail"].is-dragging * { user-select:none; }
                        #our-doctors .doc-desc { scrollbar-width:none; }
                        #our-doctors .doc-desc::-webkit-scrollbar { display:none; }
                    </style>


                    @foreach($items as $doc)
                        <article data-card
                                 class="relative snap-start shrink-0
                                  w-[88%] mb-5 sm:w-[70%] md:w-[48%] lg:w-[33%] xl:w-[32%]
                                        overflow-visible rounded-lg
                                        shadow-[0_8px_10px_rgba(0,0,0,0.03)]
                                        hover:shadow-[0_10px_10px_rgba(0,0,0,0.02)]
                                        transition-shadow duration-300 ease-out">

                            <div class="h-full overflow-hidden rounded-lg border border-main-200/70 bg-white flex flex-col">

                                <!-- IMAGE -->
                                <div class="relative h-[420px] sm:h-[600px] lg:h-[445px] shrink-0">
                                    <img
                                        src="{{ isset($doc['photo']) ? asset($doc['photo']) : asset('img/clinic/clinic-2.jpg') }}"
                                        alt="{{ $doc['name'] ?? 'Doctor' }}"
                                        class="absolute pointer-events-none h-full inset-0 z-0  w-full object-cover object-[50%_35%]"
                                    />

                                    <div class="pointer-events-none absolute inset-0 z-10
                                                bg-gradient-to-t from-black/70 via-black/18 to-transparent"></div>
                                    <div class="pointer-events-none absolute inset-0 z-10 opacity-70
                                                [background:radial-gradient(900px_260px_at_30%_10%,rgba(255,255,255,0.16),transparent_55%)]"></div>

                                    <div class="absolute left-8 right-8 bottom-7 z-20">
                                        <h3 class="text-[23px] font-normal text-white">
                                            {{ $doc['name'] ?? '' }}
                                        </h3>
                                        @if(!empty($doc['title']))
                                            <p class="mt-0.5 text-[14px] font-light text-white/65">
                                                {{ $doc['title'] }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</section>
