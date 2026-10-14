<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class RealPhone implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || $value === '') {
            return;
        }

        $util = PhoneNumberUtil::getInstance();

        try {
            $proto = $util->parse($value, null);
        } catch (NumberParseException) {
            $fail(__('validation.custom.phone.valid_phone'));
            return;
        }

        if (!$util->isValidNumber($proto)) {
            $fail(__('validation.custom.phone.valid_phone'));
            return;
        }

        $national = (string) $proto->getNationalNumber();
        if (!self::isRealistic($national)) {
            $fail(__('validation.custom.phone.valid_phone'));
        }
    }

    // libphonenumber "valid" dese de bariz test kalıplarını reddet.
    // Örn: +90 551 555 55 55 → 5515555555 (7 tane 5 üst üste).
    public static function isRealistic(string $national): bool
    {
        if (strlen($national) < 6) return false;

        // 6+ arka arkaya aynı rakam
        if (preg_match('/(\d)\1{5,}/', $national)) return false;

        // 3'ten az farklı rakam (örn 1212121212)
        $unique = count(array_unique(str_split($national)));
        if ($unique <= 2) return false;

        // Bariz artan/azalan diziler
        if (in_array($national, ['0123456789', '1234567890', '9876543210', '0987654321'], true)) {
            return false;
        }

        return true;
    }
}
