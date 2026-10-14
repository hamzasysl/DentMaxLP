@props(['title' => config('brand.name'), 'sub' => 'ORTODONTİ', 'tone' => 'dark'])
{{-- Kahraman Ortodonti logosu: diş + K monogramı + kelime markası.
     Boyut font-size ile verilir; tone="light" koyu zeminler (footer) için.
     <x-logo class="text-[20px]" />  ·  <x-logo tone="light" class="text-[24px]" /> --}}
@php($light = $tone === 'light')
<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-[0.5em] select-none leading-none']) }} role="img" aria-label="{{ $title }}"
      style="--logo-ink: {{ $light ? '#ffffff' : 'var(--color-brand-900)' }}; --logo-accent: #c9973f;">
    <x-logo-mark class="h-[2.15em] w-auto shrink-0" />

    <span class="inline-grid w-max">
        <span class="font-display text-[1em] font-semibold tracking-[0.2em] [margin-right:-0.2em] {{ $light ? 'text-white' : 'text-brand-900' }}">KAHRAMAN</span>
        <span aria-hidden="true" class="mt-[0.45em] font-mono text-[0.44em] font-medium tracking-[0.3em] {{ $light ? 'text-brand-200' : 'text-brand-600' }}">{{ $sub }}</span>
    </span>
</span>
