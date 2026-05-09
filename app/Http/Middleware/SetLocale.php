<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('localization.supported_locales', []);
        $defaultLocale = (string) config('app.locale', 'ar');

        $locale = (string) ($request->query('lang')
            ?: $request->session()->get('locale')
            ?: $defaultLocale);

        if (! array_key_exists($locale, $supportedLocales)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);
        Carbon::setLocale($locale);
        $request->session()->put('locale', $locale);

        View::share('currentLocale', $locale);
        View::share('supportedLocales', $supportedLocales);
        View::share('currentDirection', data_get($supportedLocales, "{$locale}.direction", 'rtl'));

        $response = $next($request);
        $response->headers->set('Content-Language', $locale);

        return $response;
    }
}
