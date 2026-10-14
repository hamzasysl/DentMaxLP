<?php

return [

    '404' => [
        'title' => 'Sayfa bulunamadı',
        'message' => 'Aradığınız sayfa bulunamadı veya kaldırılmış olabilir.',
        'action' => 'Ana sayfaya dön',
    ],

    '403' => [
        'title' => 'Erişim reddedildi',
        'message' => 'Bu sayfaya erişim yetkiniz bulunmuyor.',
        'action' => 'Geri dön',
    ],

    '500' => [
        'title' => 'Sunucu hatası',
        'message' => 'Bir hata oluştu. Lütfen daha sonra tekrar deneyin.',
        'action' => 'Sayfayı yenile',
    ],

    'generic' => [
        'title' => 'Bir hata oluştu',
        'message' => 'Beklenmeyen bir hata meydana geldi.',
        'action' => 'Geri dön',
    ],

];
