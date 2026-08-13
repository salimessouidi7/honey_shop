<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    // The list of languages this app currently supports. Adding a new one
    // later is just: add its code here, add resources/lang/{code}.json,
    // and add a switcher link in the layout.
    public const SUPPORTED_LOCALES = ['en', 'ar'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = session('locale', config('app.locale'));

        if (in_array($locale, self::SUPPORTED_LOCALES)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
