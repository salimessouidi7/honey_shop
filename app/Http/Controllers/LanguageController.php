<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(string $locale, Request $request)
    {
        if (!in_array($locale, SetLocale::SUPPORTED_LOCALES)) {
            abort(404);
        }

        session(['locale' => $locale]);

        return back();
    }
}
