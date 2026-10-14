<?php

namespace App\Services;

class ClientIp
{
    public static function get(): string
    {
        $cf  = request()->header('cf-connecting-ip');
        $xff = request()->header('x-forwarded-for');
        $xri = request()->header('x-real-ip');

        if ($cf)  return trim($cf);
        if ($xff) return trim(explode(',', $xff)[0]);
        if ($xri) return trim($xri);

        return request()->ip() ?: 'unknown';
    }
}
