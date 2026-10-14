<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RealName implements ValidationRule
{
    private const BLOCKED = [
        'test', 'testtest', 'test1', 'test123', 'tester',
        'asd', 'asdf', 'asdfg', 'asdfgh', 'asdasd', 'asdasdasd',
        'qwe', 'qwer', 'qwert', 'qwerty', 'qweqwe',
        'zxc', 'zxcv', 'zxcvbn',
        'admin', 'root', 'user', 'demo', 'sample', 'example',
        'foo', 'bar', 'baz', 'foobar', 'abc', 'abcd', 'xyz',
        'aaa', 'bbb', 'ccc', 'zzz', 'xxx',
        'name', 'ad', 'adsoyad', 'fullname',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || $value === '') {
            return;
        }

        $trimmed = trim($value);
        $lower = mb_strtolower($trimmed, 'UTF-8');
        $collapsed = preg_replace('/\s+/', '', $lower);

        // "test test" gibi tekrarları da yakala
        if ($collapsed !== null && preg_match('/^(.+?)\1+$/', $collapsed)) {
            $fail(__('validation.custom.name.real_name'));
            return;
        }

        // Tam eşleşme: bariz test/dummy adlar
        foreach (self::BLOCKED as $bad) {
            if ($lower === $bad || $collapsed === $bad) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }
        }

        // "aaaaa", "1111" gibi tekrarlı tek karakter (3+)
        if (preg_match('/^(.)\1{2,}$/u', $collapsed ?? '')) {
            $fail(__('validation.custom.name.real_name'));
            return;
        }

        // 4+ arka arkaya aynı harf: "asaaaaf", "qweeeer"
        if (preg_match('/(.)\1{3,}/u', $collapsed ?? '')) {
            $fail(__('validation.custom.name.real_name'));
            return;
        }

        // Klavye yürüyüşü: qwer, asdf, zxcv, 1234
        $keyboard = ['qwert', 'asdfg', 'zxcvb', 'yuiop', 'hjklm', '12345', '54321', 'abcde'];
        foreach ($keyboard as $seq) {
            if (str_contains($collapsed ?? '', $seq)) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }
        }

        // Rakam ağırlıklı isim (yarıdan fazlası rakamsa reddet)
        $digits = preg_match_all('/\d/', $trimmed);
        $letters = preg_match_all('/[\p{L}]/u', $trimmed);
        if ($digits > 0 && $letters === 0) {
            $fail(__('validation.custom.name.real_name'));
            return;
        }

        // En az 2 harf içermeli
        if ($letters < 2) {
            $fail(__('validation.custom.name.real_name'));
            return;
        }

        // Klavye ezme tespiti — gerçek isimlerde nadir olan kalıplar
        $justLetters = preg_replace('/[^\p{L}]/u', '', $lower) ?? '';
        $len = mb_strlen($justLetters, 'UTF-8');

        if ($len > 0) {
            $unique = count(array_unique(mb_str_split($justLetters, 1, 'UTF-8')));

            // 12+ karakter uzunluğunda 5'ten az farklı harf → tekrarlı ezme
            if ($len >= 12 && $unique <= 5) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }

            // Ünlü harflerin çeşitliliği: 8+ harfte 2'den az farklı ünlü → sahte
            $vowels = preg_match_all('/[aeıioöuüéèá]/u', $justLetters);
            $uniqueVowels = count(array_unique(preg_split('//u',
                preg_replace('/[^aeıioöuüéèá]/u', '', $justLetters) ?? '', -1, PREG_SPLIT_NO_EMPTY)));
            if ($len >= 8 && $uniqueVowels < 2) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }

            // Ünlü oranı: %15'ten az veya %70'ten fazla → sahte (gerçek isim ~%35-50)
            if ($len >= 6) {
                $vowelRatio = $vowels / $len;
                if ($vowelRatio < 0.15 || $vowelRatio > 0.75) {
                    $fail(__('validation.custom.name.real_name'));
                    return;
                }
            }

            // 5+ arka arkaya ünsüz (gerçek isimlerde neredeyse yok)
            if (preg_match('/[bcçdfgğhjklmnprsştvwxyzq]{5,}/u', $justLetters)) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }
        }

        // Boşluksuz tek kelime > 22 karakter → gerçek isim değil
        $words = preg_split('/\s+/', $trimmed);
        foreach ($words ?: [] as $w) {
            if (mb_strlen($w, 'UTF-8') > 22) {
                $fail(__('validation.custom.name.real_name'));
                return;
            }
        }
    }
}
