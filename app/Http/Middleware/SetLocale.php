<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->detect($request);

        App::setLocale($locale);
        Session::put('locale', $locale);

        $response = $next($request);

        // Persist choice in cookie for 1 year
        return $response->withCookie(cookie('locale', $locale, 60 * 24 * 365));
    }

    private function detect(Request $request): string
    {
        // Safe fallback — if DB isn't ready yet, use 'az'
        try {
            $supported = Locale::activeCodes();
        } catch (\Throwable) {
            return 'az';
        }

        if (empty($supported)) {
            return 'az';
        }

        // 1. URL ?lang= parameter (language switcher)
        if ($request->has('lang') && in_array($request->input('lang'), $supported, true)) {
            return $request->input('lang');
        }

        // 2. Session
        $sessionLocale = Session::get('locale');
        if ($sessionLocale && in_array($sessionLocale, $supported, true)) {
            return $sessionLocale;
        }

        // 3. Cookie
        $cookieLocale = $request->cookie('locale');
        if ($cookieLocale && in_array($cookieLocale, $supported, true)) {
            return $cookieLocale;
        }

        // 4. Browser Accept-Language
        $browser = $request->getPreferredLanguage($supported);
        if ($browser) {
            return $browser;
        }

        // 5. Default from DB
        try {
            return Locale::defaultCode();
        } catch (\Throwable) {
            return 'az';
        }
    }
}
