<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RealEmail implements ValidationRule
{
    private const BLOCKED_DOMAINS = [
        'test.com', 'test.net', 'test.org', 'test.co',
        'example.com', 'example.net', 'example.org', 'example.co',
        'sample.com', 'demo.com', 'fake.com', 'foo.com', 'bar.com',
        'asdf.com', 'qwerty.com', 'abc.com', 'xyz.com',
        'mail.com', 'email.com',
        'mailinator.com', 'guerrillamail.com', 'guerrillamail.net', 'guerrillamail.org',
        'tempmail.com', 'temp-mail.org', 'temp-mail.io', 'tempmailo.com',
        '10minutemail.com', '10minutemail.net', '20minutemail.com',
        'yopmail.com', 'yopmail.net', 'trashmail.com', 'trashmail.net',
        'dispostable.com', 'throwawaymail.com', 'sharklasers.com',
        'maildrop.cc', 'getnada.com', 'mohmal.com', 'fakeinbox.com',
        'spam4.me', 'spamgourmet.com', 'mytemp.email',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!is_string($value) || $value === '') {
            return;
        }

        $at = strrpos($value, '@');
        if ($at === false) {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }

        $local  = substr($value, 0, $at);
        $domain = strtolower(substr($value, $at + 1));

        if ($domain === '' || $local === '') {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }

        // TLD şart, tek parça (.local, localhost vb.) reddedilir
        if (!str_contains($domain, '.')) {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }

        $tld = substr(strrchr($domain, '.'), 1);
        if (strlen($tld) < 2 || !ctype_alpha($tld)) {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }

        if (in_array($domain, self::BLOCKED_DOMAINS, true)) {
            $fail(__('validation.custom.email.disposable'));
            return;
        }

        $localLower = strtolower($local);

        // Bariz test/placeholder yerel adlar
        $blockedLocals = [
            'test', 'tests', 'testing', 'test1', 'test123', 'testtest',
            'asd', 'asdf', 'asdfg', 'asdasd', 'asdasdasd',
            'qwe', 'qwer', 'qwerty', 'qweqwe',
            'admin', 'root', 'user', 'demo', 'example', 'sample',
            'noreply', 'no-reply', 'donotreply', 'do-not-reply',
            'foo', 'bar', 'baz', 'foobar', 'abc', 'abcd', 'xyz',
            'aaa', 'bbb', 'ccc', 'ddd', 'zzz', 'xxx',
            '123', '1234', '12345', '123456',
        ];
        if (in_array($localLower, $blockedLocals, true)) {
            $fail(__('validation.custom.email.disposable'));
            return;
        }

        // "aaaa@..." veya "1111@..." gibi tek karakter tekrarı
        if (preg_match('/^(.)\1{2,}$/', $local)) {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }

        // "test.xyz@..." veya "test_asdf@..." gibi "test" ile başlayanlar
        if (preg_match('/^test\d*[._-]?\w*$/i', $local) && strlen($local) <= 12) {
            $fail(__('validation.custom.email.disposable'));
            return;
        }

        // 3+ arka arkaya aynı karakter (aaaa, 1111)
        if (preg_match('/(.)\1{3,}/', $local)) {
            $fail(__('validation.custom.email.valid_email'));
            return;
        }
    }
}
