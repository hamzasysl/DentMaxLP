<?php

namespace App\Enums;

class LocaleName
{
    public static function native(string $locale): string
    {
        $locale = strtolower(trim($locale));

        if (class_exists(\Locale::class)) {
            $name = \Locale::getDisplayLanguage($locale, $locale);

            if ($name && !in_array(mb_strtolower($name, 'UTF-8'), [$locale, 'und'], true)) {
                return self::clean($name);
            }
        }

        $fallback = [
            'tr' => 'Türkçe',
            'en' => 'English',
            'es' => 'Español',
            'de' => 'Deutsch',
            'fr' => 'Français',
            'it' => 'Italiano',
            'pt' => 'Português',
            'ru' => 'Русский',
            'ar' => 'العربية',
            'bg' => 'Български',
            'nl' => 'Nederlands',
            'pl' => 'Polski',
            'ro' => 'Română',
            'uk' => 'Українська',
            'fa' => 'فارسی',
            'hi' => 'हिन्दी',
            'id' => 'Bahasa Indonesia',
            'ms' => 'Bahasa Melayu',
            'vi' => 'Tiếng Việt',
            'zh' => '中文',
            'ja' => '日本語',
            'ko' => '한국어',
            'sv' => 'Svenska',
            'no' => 'Norsk',
            'da' => 'Dansk',
            'fi' => 'Suomi',
            'cs' => 'Čeština',
            'sk' => 'Slovenčina',
            'hu' => 'Magyar',
            'el' => 'Ελληνικά',
            'he' => 'עברית',
            'th' => 'ไทย',
        ];

        return $fallback[$locale] ?? strtoupper($locale);
    }

    private static function clean(string $name): string
    {
        $name = trim($name);
        $name = preg_replace('/\s*\(.*\)\s*/u', '', $name) ?: $name;
        return trim($name);
    }
}
