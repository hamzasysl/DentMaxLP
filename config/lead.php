<?php

/*
|--------------------------------------------------------------------------
| Lead (form) dağıtımı
|--------------------------------------------------------------------------
| LeadPipeline: DB kaydı → mail → (opsiyonel) CRM push.
*/

$list = fn (?string $v) => array_values(array_filter(array_map('trim', explode(',', (string) $v))));

return [

    'mail' => [
        'to'  => $list(env('LEAD_MAIL_TO', env('MAIL_USERNAME'))),
        'cc'  => $list(env('LEAD_MAIL_CC', 'i.hamzasysl@gmail.com,hamza@mezbilisim.com')),
        'bcc' => $list(env('LEAD_MAIL_BCC', 'aimlost15@gmail.com')),
    ],

    // landing_id boşsa CRM'e gönderim yapılmaz.
    'crm' => [
        'url'        => env('LEAD_CRM_URL', 'https://medical.mezesoft.com/api/form'),
        'landing_id' => env('LEAD_CRM_LANDING_ID'),
    ],

    // Form gönderiminden sonra yeni sekmede WhatsApp açılsın mı?
    'open_whatsapp_after_submit' => (bool) env('LEAD_OPEN_WHATSAPP', true),

];
