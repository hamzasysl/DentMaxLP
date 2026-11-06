@props(['title' => config('brand.name'), 'tone' => 'dark'])
{{-- Kahraman Ortodonti yatay logosu: solda diş ikonu, sağda kelime markası + Ortodonti (public/img/logo.svg, #logo).
     Boyut font-size ile verilir; tone="light" koyu zeminler (footer) için.
     <x-logo class="text-[20px]" />  ·  <x-logo tone="light" class="text-[24px]" /> --}}
@php($light = $tone === 'light')
<span {{ $attributes->merge(['class' => 'inline-flex select-none leading-none']) }} role="img" aria-label="{{ $title }}"
      style="--logo-ink: {{ $light ? '#ffffff' : 'var(--color-brand-700)' }}; --logo-accent: {{ $light ? '#e2b979' : '#c9973f' }};">
    <svg class="h-[3em] w-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 7756 1880" aria-hidden="true">
        <use href="{{ asset('img/logo.svg') . '?v=' . @filemtime(public_path('img/logo.svg')) }}#logo"/>
    </svg>
</span>
