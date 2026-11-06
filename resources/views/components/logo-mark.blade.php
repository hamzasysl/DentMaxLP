{{-- Kahraman Ortodonti logo işareti: diş + K monogramı + yıldızlar (public/img/logo.svg, #mark).
     Renkler CSS değişkeni: --logo-ink (yeşil), --logo-accent (altın) --}}
<svg {{ $attributes }} xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1504 2424" aria-hidden="true">
    <use href="{{ asset('img/logo.svg') . '?v=' . @filemtime(public_path('img/logo.svg')) }}#mark"/>
</svg>
