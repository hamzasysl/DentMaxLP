@props([
    'options'     => [],       // ['Değer', ...] veya ['value' => 'Etiket', ...]
    'placeholder' => 'Seçiniz',
    'id'          => null,
    'invalid'     => false,
    'dark'        => false,     // koyu zemin (yatay form bandı)
])
{{--
    Özel select (Alpine + Livewire). Kullanım:
    <x-ui.select wire:model="topic" :options="$topics" placeholder="Seçiniz" />
    Klavye: ↑ ↓ gezin, Enter/Space seç, Esc kapat, harf yazarak ara.
    Liste <body>'ye taşınır (x-teleport) ve ekrana göre konumlanır; overflow-hidden
    bölümler kesmez, altta yer yoksa yukarı açılır.
--}}
@php
    $isList = array_is_list($options);
    $items  = collect($options)->map(fn ($label, $value) => [
        'value' => (string) ($isList ? $label : $value),
        'label' => (string) $label,
    ])->values()->all();

    $id = $id ?? 'ui-select-' . \Illuminate\Support\Str::random(6);
@endphp

<div x-data="{
        open: false,
        value: @entangle($attributes->wire('model')),
        items: @js($items),
        active: -1,
        query: '',
        queryTimer: null,
        pos: '',
        dropUp: false,
        place() {
            const r = this.$refs.button.getBoundingClientRect();
            if (this.open && (r.bottom < 0 || r.top > window.innerHeight)) return this.close(false);
            const h = Math.min(this.$refs.panel?.offsetHeight || 300, 340);
            const below = window.innerHeight - r.bottom, above = r.top;
            this.dropUp = below < h + 16 && above > below;
            this.pos = `left:${r.left}px;width:${r.width}px;` +
                (this.dropUp ? `bottom:${window.innerHeight - r.top + 8}px;` : `top:${r.bottom + 8}px;`);
        },
        get selected() { return this.items.find(i => i.value === this.value) },
        toggle() { this.open ? this.close() : this.show() },
        show() {
            this.place();
            this.open = true;
            this.active = Math.max(0, this.items.findIndex(i => i.value === this.value));
            this.$nextTick(() => { this.place(); this.scrollToActive() });
        },
        close(focus = true) { this.open = false; if (focus) this.$refs.button.focus() },
        choose(i) { this.value = this.items[i].value; this.close() },
        clear() { this.value = ''; this.close() },
        move(step) {
            if (!this.open) return this.show();
            this.active = (this.active + step + this.items.length) % this.items.length;
            this.scrollToActive();
        },
        scrollToActive() { this.$refs.list?.children[this.active]?.scrollIntoView({ block: 'nearest' }) },
        typeahead(e) {
            if (e.key.length !== 1 || e.metaKey || e.ctrlKey) return;
            clearTimeout(this.queryTimer);
            this.query += e.key.toLocaleLowerCase('tr');
            this.queryTimer = setTimeout(() => this.query = '', 600);
            const i = this.items.findIndex(it => it.label.toLocaleLowerCase('tr').startsWith(this.query));
            if (i > -1) { this.active = i; if (!this.open) this.show(); this.scrollToActive(); }
        },
     }"
     @click.outside="open && !$refs.panel?.contains($event.target) && close(false)"
     @keydown.escape.prevent.stop="close()"
     {{ $attributes->whereDoesntStartWith('wire:model')->merge(['class' => 'relative']) }}>

    <button type="button" id="{{ $id }}" x-ref="button"
            @click="toggle()"
            @keydown.arrow-down.prevent="move(1)"
            @keydown.arrow-up.prevent="move(-1)"
            @keydown.enter.prevent="open && active > -1 ? choose(active) : show()"
            @keydown.space.prevent="open && active > -1 ? choose(active) : show()"
            @keydown="typeahead($event)"
            aria-haspopup="listbox"
            :aria-expanded="open"
            @if($dark)
            :class="open ? 'border-brand-300 ring-4 ring-brand-300/15' : '{{ $invalid ? '!border-red-400' : 'border-white/15 hover:border-white/30' }}'"
            class="flex h-10 w-full cursor-pointer items-center justify-between gap-3 rounded-lg border bg-white/[0.06] px-3.5 text-left text-[16px] transition focus:outline-none focus-visible:border-brand-300 focus-visible:ring-4 focus-visible:ring-brand-300/15">
        <span class="truncate" :class="selected ? 'text-white' : 'text-white/50'"
            @else
            :class="open ? 'border-brand-500 ring-4 ring-brand-500/10' : '{{ $invalid ? '!border-red-400' : 'border-main-200 hover:border-main-300' }}'"
            class="flex h-12 w-full cursor-pointer items-center justify-between gap-3 rounded-xl border bg-white px-4 text-left text-[15px] transition focus:outline-none focus-visible:border-brand-500 focus-visible:ring-4 focus-visible:ring-brand-500/10">
        <span class="truncate" :class="selected ? 'text-main-900' : 'text-main-300'"
            @endif
              x-text="selected ? selected.label : @js($placeholder)">{{ $placeholder }}</span>
        <i class="fa-solid fa-chevron-down shrink-0 text-[11px] {{ $dark ? 'text-white/50' : 'text-main-400' }} transition-transform duration-200"
           :class="open && 'rotate-180 {{ $dark ? 'text-white' : 'text-brand-600' }}'"></i>
    </button>

    <template x-teleport="body">
    <div x-ref="panel" x-show="open" x-cloak :style="pos"
         @scroll.window.capture.passive="open && place()"
         @resize.window="open && place()"
         @keydown.escape.prevent.stop="close()"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-[.98]"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         :class="dropUp ? 'origin-bottom' : 'origin-top'"
         class="fixed z-[100010] overflow-hidden rounded-2xl bg-white p-1.5 shadow-[0_20px_50px_-12px_rgba(10,19,20,.25)] ring-1 ring-main-100">

        <ul x-ref="list" role="listbox" aria-labelledby="{{ $id }}" class="max-h-64 overflow-y-auto overscroll-contain">
            <template x-for="(item, i) in items" :key="item.value">
                <li role="option" :aria-selected="item.value === value"
                    @click="choose(i)" @mouseenter="active = i"
                    :class="{
                        'bg-main-100 text-main-900': active === i,
                        'text-main-700': active !== i,
                        'font-semibold': item.value === value,
                    }"
                    class="flex cursor-pointer items-center justify-between gap-3 rounded-xl px-3.5 py-2.5 text-[14.5px] transition-colors">
                    <span x-text="item.label"></span>
                    <i x-show="item.value === value" class="fa-solid fa-check text-[12px] text-brand-600"></i>
                </li>
            </template>
        </ul>

        <button type="button" x-show="value" @click="clear()"
                class="mt-1 flex w-full cursor-pointer items-center gap-2 rounded-xl border-t border-main-100 px-3.5 pt-2.5 pb-2 text-[13px] text-main-400 transition hover:text-main-700">
            <i class="fa-solid fa-xmark text-[11px]"></i> Seçimi temizle
        </button>
    </div>
    </template>
</div>
