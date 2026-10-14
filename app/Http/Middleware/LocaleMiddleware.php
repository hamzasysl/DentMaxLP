<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$this->shouldHandle($request)) {
            return $next($request);
        }

        $defaultLp = config('brand.default_lp');

        $urlLangRaw    = $request->segment(1);
        $cookieLangRaw = $request->cookie('locale');

        $urlLang     = $this->cleanLocale($urlLangRaw);
        $cookieLang  = $this->cleanLocale($cookieLangRaw);
        $browserLang = $this->cleanLocale($this->browserLang($request));

        // Bozuk cookie varsa sil
        if ($cookieLangRaw && !$cookieLang) {
            cookie()->queue(cookie()->forget('locale'));
        }

        /*
        |--------------------------------------------------------------------------
        | 1) Cookie varsa: HER ZAMAN baskın (tarayıcı dili yok sayılır)
        |--------------------------------------------------------------------------
        */
        if ($cookieLang) {
            if ($urlLang !== $cookieLang) {
                // lang yokken sadece LP slug gibi path’lerde redirect
                if (!$urlLang && !$this->shouldRedirectMissingLang($request)) {
                    return $next($request);
                }
                return $this->redirectWithLang($request, $cookieLang);
            }

            app()->setLocale($cookieLang);

            // /tr gibi geldiyse -> /tr/{defaultLp}
            if ($urlLang && !$request->segment(2)) {
                return redirect("/{$cookieLang}/{$defaultLp}");
            }

            return $next($request);
        }

        /*
        |--------------------------------------------------------------------------
        | 2) Cookie yoksa:
        | - URL'de LANG VARSA => KULLANICI SEÇMİŞTİR, ASLA tarayıcı diline zorlamayız.
        | - URL'de LANG YOKSA => tarayıcı dilini prefix olarak ekleriz (slug ise).
        |--------------------------------------------------------------------------
        */

        // URL'de desteklenmeyen 2 harfli dil varsa (/en/invisalign) default dile çevir
        if (!$urlLang && preg_match('/^[a-zA-Z]{2}$/', (string) $urlLangRaw)) {
            return $this->redirectWithLang($request, $browserLang ?? config('brand.default_locale'));
        }

        // URL'de lang varsa set et; sadece /tr ise default LP'ye yönlendir
        if ($urlLang) {
            app()->setLocale($urlLang);

            // /tr gibi geldiyse -> /tr/{defaultLp}
            if (!$request->segment(2)) {
                return redirect("/{$urlLang}/{$defaultLp}");
            }

            return $next($request);
        }

        // URL'de lang yoksa: sadece slug gibi path’lerde tarayıcı dilini prefix ekle
        $target = $browserLang ?? config('brand.default_locale');

        // ROOT (/) ise direkt /{lang}/{defaultLp}
        if (ltrim($request->path(), '/') === '') {
            return redirect("/{$target}/{$defaultLp}");
        }

        if ($this->shouldRedirectMissingLang($request)) {
            return $this->redirectWithLang($request, $target);
        }

        return $next($request);
    }

    private function browserLang(Request $request): ?string
    {
        foreach ($request->getLanguages() as $lang) {
            return strtolower(strtok($lang, '-')); // tr-TR -> tr
        }
        return null;
    }

    // Sadece config('brand.locales') içindeki diller geçerli sayılır
    private function cleanLocale(?string $locale): ?string
    {
        if (!$locale) return null;
        $locale = strtolower($locale);
        return in_array($locale, config('brand.locales'), true) ? $locale : null;
    }

    private function shouldRedirectMissingLang(Request $request): bool
    {
        $path = ltrim($request->path(), '/');
        if ($path === '') return true;

        $first = (string) $request->segment(1);

        if (str_contains($first, '.')) return false;

        return (bool) preg_match('/^[a-z0-9-]{2,60}$/', $first);
    }

    private function redirectWithLang(Request $request, string $lang)
    {
        $segments = $request->segments();

        if (!empty($segments) && preg_match('/^[a-zA-Z]{2}$/', $segments[0])) {
            array_shift($segments);
        }

        $path = implode('/', $segments);
        $url  = $path === '' ? "/{$lang}" : "/{$lang}/{$path}";

        if ($request->getQueryString()) {
            $url .= '?' . $request->getQueryString();
        }

        return redirect($url);
    }

    private function shouldHandle(Request $request): bool
    {
        if (!in_array($request->method(), ['GET', 'HEAD'], true)) return false;

        $path = ltrim($request->path(), '/');

        foreach (['livewire', 'storage', 'vendor', 'up', '_debugbar'] as $prefix) {
            if ($path !== '' && str_starts_with($path, $prefix)) {
                return false;
            }
        }

        return true;
    }
}
