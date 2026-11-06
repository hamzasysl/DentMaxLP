<?php

/*
|--------------------------------------------------------------------------
| Hasta hikayeleri
|--------------------------------------------------------------------------
| /hasta-hikayeleri (liste) ve /hasta-hikayeleri/{slug} (detay) bu dosyadan beslenir.
|
| publish=false iken: sayfalar açılır ama Google'a kapalıdır (noindex) ve menü/footer'da
| link görünmez. Gerçek hikayeler eklenince STORIES_PUBLISH=true yapılır.
|
| Fotoğraflar: public/img/stories/{slug}/ altına konur (before.webp, after.webp, ...).
| Fotoğraf yoksa sayfa şık bir yer tutucu gösterir.
|
| 'example' => true olan kayıtlar yalnızca örnektir; gerçek içerik gelince silinecek.
*/

return [

    'publish' => (bool) env('STORIES_PUBLISH', false),

    'items' => [

        [
            // Gerçek vaka: doğum tarihi ve hasta numarası kullanılmaz.
            // Klinik plan ayrıntısı yazılmaz; yalnız hekimin onayladığı bilgiler eklenir.
            'slug'      => 'dis-arasi-bosluk-plani',
            'name'      => 'Melek Açıkgöz',
            'age'       => 34,
            'condition' => 'bosluk',
            'condition_label' => 'Dişler arası boşluk',
            'title'     => ['Melek Hanım’ın', 'Invisalign Yolculuğu'],
            'stages'    => 28,
            'started'   => 'Eylül 2023',
            'location'  => 'İstanbul',
            'summary'   => 'Melek Hanım’ın şeffaf plak tedavisi, ClinCheck® ile planlanan 28 aşamadan oluşuyor. Dijital planı, 3D modeli ve tedavi sürecini bu sayfada inceleyebilirsiniz.',
            'photos'    => [
                'before'  => null,
                'after'   => null,
                'cover'   => 'img/stories/dis-arasi-bosluk-plani/plan-poster.jpg',
                'portrait' => 'img/stories/dis-arasi-bosluk-plani/portre.webp',
                'xray'    => 'img/stories/dis-arasi-bosluk-plani/panoramik.webp',
                'gallery' => [
                    ['src' => 'img/stories/dis-arasi-bosluk-plani/yan-1.webp',    'label' => 'Yandan görünüm'],
                    ['src' => 'img/stories/dis-arasi-bosluk-plani/yan-2.webp',    'label' => 'Diğer taraf'],
                    ['src' => 'img/stories/dis-arasi-bosluk-plani/ust-cene.webp', 'label' => 'Üst çene'],
                    ['src' => 'img/stories/dis-arasi-bosluk-plani/alt-cene.webp', 'label' => 'Alt çene'],
                ],
            ],
            'video'     => ['src' => 'img/stories/dis-arasi-bosluk-plani/plan.mp4', 'poster' => 'img/stories/dis-arasi-bosluk-plani/plan-poster.jpg'],
            'model'     => 'img/stories/dis-arasi-bosluk-plani/model.bin',
            'timeline' => [
                ['when' => 'Eylül 2023',  'title' => 'Reçete gönderildi',       'text' => 'Tedavi reçetesi ve kayıtlar iletildi.'],
                ['when' => 'Eylül 2023',  'title' => 'ClinCheck® planı onaylandı', 'text' => 'Dijital tedavi planı onaylandı.'],
                ['when' => 'Eylül 2023',  'title' => 'Plaklar gönderildi',      'text' => 'Onaylanan plana göre plaklar gönderildi.'],
                ['when' => 'Ekim 2023',   'title' => 'Yeni reçete gönderildi',  'text' => 'Uyum Garantisi kapsamında yeni reçete ve kayıtlar iletildi.'],
                ['when' => 'Kasım 2023',  'title' => 'ClinCheck® planı onaylandı', 'text' => 'Güncel dijital tedavi planı onaylandı.'],
                ['when' => 'Aralık 2023', 'title' => 'Plaklar gönderildi',      'text' => 'Güncel plana göre plaklar gönderildi.'],
            ],
        ],

    ],
];
