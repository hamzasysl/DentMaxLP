<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if($gtmId = config('brand.gtm_id'))
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer',@js($gtmId));</script>
    <!-- End Google Tag Manager -->
    @endif

    <meta charset="utf-8">

    @php
        $seo = $seo ?? [];

        // Base + page override birleşmiş halde payload'dan geliyor
        $pageTitle = $seo['title'] ?? ($title ?? config('app.name'));
        $pageDesc  = $seo['description'] ?? '';
        $ogImage   = $seo['og_image'] ?? asset('img/seo/default-og.jpg');

        $canonical = $seo['canonical'] ?? url()->current();
        $robots    = $seo['robots'] ?? 'index,follow';

        $siteName  = config('brand.name');
        $locale    = app()->getLocale();

        // locales payload'dan geliyor (Base: ['en','tr',...])
        $localesList = $locales ?? null;

        // mevcut URL (locale zaten dahilse canonical zaten doğru)
        $currentUrl = url()->current();

        // ✅ HER YERDE: Page Title | SiteName
        $fullTitle = str_contains($pageTitle, $siteName)
            ? $pageTitle
            : ($pageTitle . ' | ' . $siteName);
    @endphp

    <title>{{ $fullTitle }}</title>
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="robots" content="{{ $robots }}">
    <link rel="canonical" href="{{ $canonical }}">
    {{-- Font Awesome: Vite ile paketleniyor (resources/css/app.css) --}}

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:locale" content="{{ $locale === 'tr' ? 'tr_TR' : $locale }}">
    <meta property="og:title" content="{{ $fullTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ $canonical }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $siteName }} – Invisalign şeffaf plak tedavisi">

    {{-- Twitter (kalsın; bazı mecralar okuyor, zarar vermez) --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $fullTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">
    <meta name="twitter:image" content="{{ $ogImage }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#4e3826">
    <meta name="author" content="{{ config('brand.doctor.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Laravel + Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/favicon.svg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('img/apple-touch-icon.png') }}">


    {{-- (Opsiyonel) hreflang: URL zaten locale’li geliyorsa sadece locale segmentini değiştirerek üret --}}
    @if(is_array($localesList) && count($localesList))
        @foreach($localesList as $lang)
            @php
                $alt = preg_replace('~/(' . implode('|', $localesList) . ')(?=/|$)~', '/' . $lang, $currentUrl, 1);
            @endphp
            <link rel="alternate" hreflang="{{ $lang }}" href="{{ $alt }}">
        @endforeach
        <link rel="alternate" hreflang="x-default" href="{{ $currentUrl }}">
    @endif

    @stack('styles')

    {{-- Fontlar --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100;200;300;400;500;600;700&family=Geist+Mono:wght@400;500&display=swap" rel="stylesheet">

    <style>
        @keyframes fadeSlide {
            0%   { opacity: 0; transform: translateY(-4px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="min-h-screen overflow-x-clip bg-white text-main-900 antialiased font-sans">

@if(config('brand.gtm_id'))
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ config('brand.gtm_id') }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif

{{-- HEADER / NAVBAR --}}
@include('partials.header')

{{-- ANA İÇERİK --}}
<main>
    {{ $slot }}
</main>

{{-- FOOTER --}}
@include('partials.footer')
@include('partials.kvkk-modal')

<livewire:ui.modals.book-consultation-modal />
@if(config('brand.features.exit_intent'))
    <livewire:ui.modals.exit-intent-modal />
@endif

{{-- MOBİL ALT İLETİŞİM BARI --}}
@include('partials.mobile-cta-bar')

@if(config('brand.features.lucky_spin'))
    <livewire:ui.modals.lucky-spin-modal />
    @include('partials.spin-trigger')
@endif

@if(config('brand.features.legacy_widgets'))
    @include('partials.legacy-widgets')
@endif

@stack('scripts')

</body>
</html>
