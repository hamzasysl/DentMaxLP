<?php

namespace App\Support;

class WhatsApp
{
    /**
     * wa.me linki üretir; mesaj verilmezse config('brand.contact.whatsapp_message') kullanılır.
     */
    public static function url(?string $phone = null, ?string $message = null): string
    {
        $phone   = preg_replace('/\D+/', '', $phone ?? config('brand.contact.whatsapp_link'));
        $message = trim($message ?? (string) config('brand.contact.whatsapp_message'));

        return 'https://wa.me/' . $phone . ($message !== '' ? '?text=' . rawurlencode($message) : '');
    }
}
