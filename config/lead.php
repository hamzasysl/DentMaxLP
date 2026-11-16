<?php

/*
|--------------------------------------------------------------------------
| Lead (form) dağıtımı
|--------------------------------------------------------------------------
| LeadPipeline: DB kaydı → mail → (opsiyonel) webhook ve CRM push.
*/

$list = fn (?string $v) => array_values(array_filter(array_map('trim', explode(',', (string) $v))));

return [

    'mail' => [
        'to'  => $list(env('LEAD_MAIL_TO', 'hamza@mezbilisim.com')),
        'cc'  => $list(env('LEAD_MAIL_CC')),
        'bcc' => $list(env('LEAD_MAIL_BCC')),
    ],

    // Mezesoft webhook'u: adres (token içerir) yalnızca sunucu .env'inde tutulur; boşsa gönderim yapılmaz.
    'webhook' => [
        'url' => env('LEAD_WEBHOOK_URL'),
    ],

    // landing_id boşsa CRM'e gönderim yapılmaz.
    'crm' => [
        'url'        => env('LEAD_CRM_URL', 'https://medical.mezesoft.com/api/form'),
        'landing_id' => env('LEAD_CRM_LANDING_ID'),
    ],

];
