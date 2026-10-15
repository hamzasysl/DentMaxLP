@props(['before' => null, 'after' => null, 'alt' => 'Tedavi öncesi ve sonrası'])
{{-- Önce/sonra karşılaştırma: ortadaki tutamaç sürüklenir (fare, dokunma, klavye).
     Fotoğraflardan biri yoksa yer tutucu gösterilir. --}}
@if($before && $after)
    <div x-data="{ pos: 50, drag: false,
                  set(e) { const r = this.$el.getBoundingClientRect(); this.pos = Math.min(100, Math.max(0, ((e.clientX - r.left) / r.width) * 100)); } }"
         @pointerdown="drag = true; set($event); $el.setPointerCapture($event.pointerId)"
         @pointermove="drag && set($event)" @pointerup="drag = false" @pointercancel="drag = false"
         {{ $attributes->merge(['class' => 'relative aspect-[4/3] cursor-ew-resize touch-pan-y select-none overflow-hidden rounded-[24px] bg-main-100']) }}>
        <img src="{{ asset($after) }}" alt="{{ $alt }} – sonra" class="absolute inset-0 h-full w-full object-cover" draggable="false">
        <img src="{{ asset($before) }}" alt="{{ $alt }} – önce" class="absolute inset-0 h-full w-full object-cover" draggable="false"
             :style="`clip-path: inset(0 ${100 - pos}% 0 0)`">

        <span class="absolute top-4 left-4 rounded-full bg-white/90 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-brand-900 backdrop-blur">Önce</span>
        <span class="absolute top-4 right-4 rounded-full bg-brand-900/85 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.18em] text-white backdrop-blur">Sonra</span>

        <div class="pointer-events-none absolute inset-y-0 w-px bg-white shadow-[0_0_0_1px_rgba(22,43,87,.15)]" :style="`left:${pos}%`">
            <span class="absolute top-1/2 left-1/2 flex h-11 w-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-brand-800 shadow-[0_10px_24px_-8px_rgba(22,43,87,.6)]">
                <i class="fa-solid fa-left-right text-[13px]"></i>
            </span>
        </div>

        <input type="range" min="0" max="100" x-model.number="pos" aria-label="Önce ve sonra arasında geçiş"
               class="absolute inset-x-0 bottom-0 h-6 w-full cursor-ew-resize opacity-0">
    </div>
@else
    <div {{ $attributes->merge(['class' => 'relative grid aspect-[4/3] grid-cols-2 gap-px overflow-hidden rounded-[24px] bg-main-200/70']) }}>
        @foreach(['Önce', 'Sonra'] as $label)
            <div class="relative flex flex-col items-center justify-center gap-3 {{ $loop->first ? 'bg-ivory' : 'bg-white' }}">
                <div aria-hidden="true" class="absolute inset-0 opacity-[.5] [background-image:radial-gradient(rgba(22,43,87,.09)_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <span class="relative inline-flex h-12 w-12 items-center justify-center rounded-full bg-white text-brand-600 ring-1 ring-main-200">
                    <i class="fa-regular fa-image text-[16px]"></i>
                </span>
                <span class="relative text-[11px] font-semibold uppercase tracking-[0.2em] {{ $loop->first ? 'text-main-500' : 'text-brand-700' }}">{{ $label }}</span>
            </div>
        @endforeach
        <span class="absolute bottom-3 left-1/2 -translate-x-1/2 rounded-full bg-white/90 px-3 py-1 text-[11px] whitespace-nowrap text-main-500 ring-1 ring-main-200">Fotoğraflar eklenecek</span>
    </div>
@endif
