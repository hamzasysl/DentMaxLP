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
            'slug'      => 'ornek-caprasik-disler',
            'example'   => true,
            'name'      => 'E. K.',
            'age'       => 27,
            'condition' => 'caprasik',          // img/invisalign/bite/{condition}.svg ikonları
            'condition_label' => 'Çapraşık dişler',
            'duration'  => '11 ay',
            'aligners'  => 24,
            'location'  => 'İstanbul',
            'finished'  => 'Eylül 2026',
            'summary'   => 'Alt ve üst ön dişlerdeki çapraşıklık nedeniyle gülerken kendini rahat hissetmiyordu. Tel takmak istemediği için şeffaf plak tedavisini tercih etti.',
            'photos'    => [
                'before'  => null,   // 'img/stories/ornek-caprasik-disler/before.webp'
                'after'   => null,
                'gallery' => [],
            ],
            'timeline' => [
                ['when' => '1. hafta', 'title' => 'Muayene ve 3D tarama', 'text' => 'Ağız içi tarama yapıldı, dişlerin hareketi dijital ortamda planlandı.'],
                ['when' => '2. hafta', 'title' => 'İlk plaklar takıldı',  'text' => 'Plakların nasıl takılıp çıkarılacağı ve günlük kullanım anlatıldı.'],
                ['when' => '5. ay',    'title' => 'Ara kontrol',          'text' => 'Dişlerin plana uygun ilerlediği görüldü, sonraki plak seti verildi.'],
                ['when' => '11. ay',   'title' => 'Tedavi tamamlandı',    'text' => 'Sonucun korunması için pekiştirme plağı (retainer) teslim edildi.'],
            ],
            'quote'       => 'Örnek hasta yorumu: gerçek içerik geldiğinde hastanın kendi cümleleriyle değiştirilecek.',
            'doctor_note' => 'Örnek hekim notu: tedavinin planlanması ve sonuç hakkında kısa bir değerlendirme buraya gelecek.',
        ],

        [
            'slug'      => 'ornek-dis-arasi-bosluk',
            'example'   => true,
            'name'      => 'M. A.',
            'age'       => 34,
            'condition' => 'bosluk',
            'condition_label' => 'Dişler arası boşluk',
            'duration'  => '7 ay',
            'aligners'  => 16,
            'location'  => 'İstanbul',
            'finished'  => 'Temmuz 2026',
            'summary'   => 'Ön dişleri arasındaki boşluklar fotoğraflarda belirgin görünüyordu. İş hayatı nedeniyle fark edilmeyen bir tedavi istiyordu.',
            'photos'    => [
                'before'  => null,
                'after'   => null,
                'gallery' => [],
            ],
            'timeline' => [
                ['when' => '1. hafta', 'title' => 'Muayene ve 3D tarama', 'text' => 'Boşlukların kapanma süreci dijital olarak planlandı.'],
                ['when' => '2. hafta', 'title' => 'İlk plaklar takıldı',  'text' => 'Günde 20–22 saat kullanım düzeni oluşturuldu.'],
                ['when' => '4. ay',    'title' => 'Ara kontrol',          'text' => 'Ön bölgedeki boşlukların büyük kısmı kapandı.'],
                ['when' => '7. ay',    'title' => 'Tedavi tamamlandı',    'text' => 'Pekiştirme plağıyla takip sürecine geçildi.'],
            ],
            'quote'       => 'Örnek hasta yorumu: gerçek içerik geldiğinde hastanın kendi cümleleriyle değiştirilecek.',
            'doctor_note' => 'Örnek hekim notu: tedavinin planlanması ve sonuç hakkında kısa bir değerlendirme buraya gelecek.',
        ],

    ],
];
