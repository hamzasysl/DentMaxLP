<?php

/*
|--------------------------------------------------------------------------
| Marka / LP Ayarları (TEK KAYNAK)
|--------------------------------------------------------------------------
| Klinik bilgileri, desteklenen diller, form/lead yönlendirmeleri burada.
| Yeni dil eklemek: 'locales' dizisine ekle + lang/{dil} klasörünü oluştur
| + resources/views/livewire/{lp}/{dil}/ view'larını ekle.
*/

return [

    'name' => env('BRAND_NAME', 'Kahraman Ortodonti'),

    // Hekim
    'doctor' => [
        'name'  => 'Yrd. Doç. Dr. Fatih Kahraman',
        'title' => 'Ortodontist',
    ],

    /*  ------------- DİL / LP  ---------------- */
    'locales'        => ['tr'],
    'default_locale' => 'tr',
    'default_lp'     => 'invisalign',

    /*  ------------- İLETİŞİM  ---------------- */
    // Muayene DentMax polikliniklerinde yapılır. LP'de ana iletişim: İstanbul
    'contact' => [
        'phone_text'    => '+90 212 570 00 33',
        'phone_link'    => '+902125700033',
        'whatsapp_text' => '+90 544 375 47 66', // TODO: Hocanın kullanacağı WhatsApp hattı teyit edilecek
        'whatsapp_link' => '+905443754766',
        // WhatsApp butonlarında hazır gelen mesaj
        'whatsapp_message' => 'Merhaba, Invisalign şeffaf plak tedavisi hakkında bilgi almak istiyorum.',
        'email'         => 'info@dentmax.com.tr',
        'address'       => 'Ataköy Towers, B Blok Kat:5 No:74, Bakırköy / İstanbul',
        'maps_link'     => 'https://maps.app.goo.gl/LgoVMbMqEYEEr7aE9',
    ],

    // Muayene yerleri
    'branches' => [
        'istanbul' => [
            'name'          => 'İstanbul',
            'clinic'        => 'DentMax İstanbul Ağız ve Diş Sağlığı Polikliniği',
            'address'       => 'Ataköy Towers, B Blok Kat:5 No:74, Bakırköy / İstanbul',
            'phone_text'    => '+90 212 570 00 33',
            'phone_link'    => '+902125700033',
            'whatsapp_link' => '+905443754766',
            'email'         => 'info@dentmax.com.tr',
            'hours'         => ['Pazartesi – Cumartesi' => '09.00 – 19.30', 'Pazar' => 'Kapalı'],
            'maps_link'     => 'https://maps.app.goo.gl/LgoVMbMqEYEEr7aE9',
        ],
        'balikesir' => [
            'name'          => 'Balıkesir',
            'clinic'        => 'DentMax Balıkesir Ağız ve Diş Sağlığı Polikliniği',
            'address'       => 'DentMax Plaza, Turgutreis Cad. No:116, Karesi / Balıkesir',
            'phone_text'    => '+90 266 246 00 26',
            'phone_link'    => '+902662460026',
            'whatsapp_link' => '+905332467726',
            'email'         => 'info@dentmax.com.tr',
            'hours'         => ['Her gün açık' => '09.00 – 23.00'],
            'maps_link'     => 'https://maps.app.goo.gl/AE2TgwB7XDGreCds7',
        ],
    ],

    // TODO: Kahraman Ortodonti hesapları gelince doldurulacak (boşlar footer'da gizlenir)
    // Google İşletme profili (yorumlar bölümündeki puan rozeti buraya bağlanır)
    'google_reviews_url' => 'https://www.google.com/maps/place/Y.+Do%C3%A7ent+Dr.+Fatih+KAHRAMAN+%2F+DentMax+%C4%B0stanbul+Bak%C4%B1rk%C3%B6y+Ortodonti+Uzman%C4%B1+%2F+invisalign+-+Di%C5%9F+Teli+-+%C5%9Eeffaf+Plak+-+MARPE/@40.9910214,28.8316032,17z/data=!3m1!4b1!4m6!3m5!1s0x14cabb55bfffffff:0x308c4dec1658b472!8m2!3d40.9910214!4d28.8341781!16s%2Fg%2F11tjsbdvvn',

    'social' => [
        'instagram' => '',
        'facebook'  => '',
        'youtube'   => '',
        'tiktok'    => '',
        'linkedin'  => '',
    ],

    /*  ------------- ÖZELLİKLER  ---------------- */
    'features' => [
        'exit_intent'    => true,  // sayfadan çıkarken randevu formu (Zürih düzeni)
        'lucky_spin'     => (bool) env('FEATURE_LUCKY_SPIN', false), // şans çarkı (bölüm + modal + sağ alt buton) — şimdilik kapalı, kodlar duruyor
        // Atom şablonundan: şans çarkı + kuponlu WA popup + sağ FAB'lar
        // (TR'de sağlık reklamı mevzuatı nedeniyle kapalı)
        'legacy_widgets' => false,
    ],

    // Form KVKK onay linki
    // TODO: Kahraman Ortodonti adına KVKK metni hazırlanınca güncellenecek
    'kvkk_url' => 'https://www.dentmax.com.tr/sayfa/kvkk',

    /*  ------------- TRACKING  ---------------- */
    'gtm_id' => env('GTM_ID'),

    // WhatsApp popup'ında gösterilen kupon kodu
    'coupon_code' => 'KAHRAMAN-26',

    /*  ------------- LEAD / FORM GÖNDERİMİ  ---------------- */
    // Form dağıtımı (mail / CRM / WhatsApp) → config/lead.php

];
