{{-- Schema.org JSON-LD: ortodonti kliniği + hekim + iki muayene yeri + SSS.
     Not: kendi sitesinde puan/yorum işaretlemesi (AggregateRating) Google tarafından desteklenmediği için eklenmedi. --}}
@php
    $home   = url('/');
    $doctor = config('brand.doctor.name');

    $dayMap = ['Pazartesi – Cumartesi' => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
               'Her gün açık'          => ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday']];

    $branches = collect(config('brand.branches'))->map(function ($b, $key) use ($home, $dayMap) {
        $hours = collect($b['hours'] ?? [])
            ->filter(fn ($t, $day) => isset($dayMap[$day]) && preg_match('/(\d{2})[.:](\d{2})\s*[–-]\s*(\d{2})[.:](\d{2})/u', $t))
            ->map(function ($t, $day) use ($dayMap) {
                preg_match('/(\d{2})[.:](\d{2})\s*[–-]\s*(\d{2})[.:](\d{2})/u', $t, $m);
                return ['@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $dayMap[$day], 'opens' => "{$m[1]}:{$m[2]}", 'closes' => "{$m[3]}:{$m[4]}"];
            })->values()->all();

        [$street, $city] = array_pad(array_map('trim', explode(',', $b['address'], 2)), 2, null);

        return array_filter([
            '@type'      => 'Dentist',
            '@id'        => $home . '#sube-' . $key,
            'name'       => config('brand.name') . ' – ' . $b['name'],
            'url'        => $home,
            'telephone'  => $b['phone_link'],
            'address'    => ['@type' => 'PostalAddress', 'streetAddress' => $b['address'], 'addressLocality' => $b['name'], 'addressCountry' => 'TR'],
            'hasMap'     => $b['maps_link'] ?? null,
            'openingHoursSpecification' => $hours ?: null,
            'parentOrganization' => ['@id' => $home . '#klinik'],
        ]);
    })->values()->all();

    $graph = [
        [
            '@type'       => 'MedicalBusiness',
            '@id'         => $home . '#klinik',
            'name'        => config('brand.name'),
            'url'         => $home,
            'logo'        => asset('img/apple-touch-icon.png'),
            'image'       => asset('img/lp/invisalign/og.jpg'),
            'description' => 'Ortodonti uzmanı ' . $doctor . ' ile İstanbul ve Balıkesir’de Invisalign şeffaf plak ve ortodonti tedavileri.',
            'telephone'   => config('brand.contact.phone_link'),
            'medicalSpecialty' => 'Dentistry',
            'areaServed'  => ['İstanbul', 'Balıkesir'],
            'sameAs'      => array_values(array_filter(array_merge(config('brand.social') ?? [], [config('brand.google_reviews_url')]))),
        ],
        [
            '@type'    => 'Physician',
            '@id'      => $home . '#hekim',
            'name'     => $doctor,
            'jobTitle' => 'Ortodonti Uzmanı',
            'image'    => asset('img/lp/invisalign/dr-fatih-kahraman.webp'),
            'url'      => $home . '#hekim',
            'medicalSpecialty' => 'Dentistry',
            'worksFor' => ['@id' => $home . '#klinik'],
            'memberOf' => [
                ['@type' => 'Organization', 'name' => 'American Association of Orthodontists'],
                ['@type' => 'Organization', 'name' => 'European Orthodontic Society'],
            ],
        ],
        ...$branches,
        [
            '@type' => 'WebPage',
            '@id'   => $home . '#sayfa',
            'url'   => $home,
            'name'  => 'Invisalign Şeffaf Plak Tedavisi İstanbul & Balıkesir',
            'inLanguage' => 'tr-TR',
            'about' => ['@id' => $home . '#klinik'],
            'primaryImageOfPage' => asset('img/lp/invisalign/og.jpg'),
        ],
    ];

    if (!empty($faqs)) {
        $graph[] = [
            '@type' => 'FAQPage',
            '@id'   => $home . '#sss',
            'mainEntity' => collect($faqs)->map(fn ($f) => [
                '@type' => 'Question',
                'name'  => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ])->values()->all(),
        ];
    }
@endphp
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@graph' => $graph], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) !!}</script>
