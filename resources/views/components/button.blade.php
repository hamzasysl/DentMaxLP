@props([
    'variant' => 'cta', // primary | outline | cta
    'type' => 'button',
    'size' => 'md',                // xs, sm, md, lg
])
<button x-data="{
        variant: @js($variant),
        size: @js($size),
    }"
    type="{{ $type }}"
    :class="{
        // Button Tipleri
        'rounded-xl bg-brand-900 hover:bg-brand-800  text-white shadow-[0_10px_10px_rgba(0,0,0,0.09)] hover:from-brand-700 hover:to-brand-500': variant === 'primary',
        'rounded-full border px-4 py-3 text-[12px] font-medium uppercase tracking-[0.20em] bg-transparent': variant === 'outline',
        'rounded-xl bg-brand-900 hover:bg-brand-800  font-normal uppercase  text-white shadow-[0_10px_30px_rgba(0,0,0,0.16)] hover:from-brand-800 hover:via-brand-700 hover:to-brand-500 hover:shadow-[0_12px_36px_rgba(0,0,0,0.18)] active:scale-[0.97]': variant === 'cta',

        '!py-2  sm:!py-2 !px-3 sm:!px-4 !text-[11px] sm:!text-[12px] !tracking-[0.01em] sm:!tracking-[0.20em]': size === 'xs',
        '!py-2 md:!py-1 !text-[9px]  !tracking-[0.20em]': size === 'lg',
        'px-4 py-3 text-[11.5px] font-medium uppercase tracking-[0.13em]': size === 'md',
    }"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center cursor-pointer transition-transform duration-200 ease-out disabled:opacity-60 disabled:pointer-events-none']) }}

>
    {{ $slot }}
</button>
