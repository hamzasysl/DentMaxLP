{{-- CTA yakınında "sınırlı kontenjan" vurgusu: yanıp sönen altın nokta + kısa metin.
     Örn: <x-quota-note class="mt-3">Kontenjan dolmadan yerinizi alın</x-quota-note> · koyu zeminde tone="dark" --}}
@props(['tone' => 'light'])
<p {{ $attributes->class([
    'flex items-center gap-2 text-[12.5px] font-medium',
    'text-[#9a6a26]' => $tone === 'light',
    'text-[#e2b979]' => $tone === 'dark',
]) }}>
    <span class="relative flex h-2 w-2 shrink-0" aria-hidden="true">
        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#c9973f] opacity-60 motion-reduce:animate-none"></span>
        <span class="relative inline-flex h-2 w-2 rounded-full bg-[#c9973f]"></span>
    </span>
    {{ $slot }}
</p>
