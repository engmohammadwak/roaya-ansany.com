<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->route('locale');

        if (in_array($locale, ['ar', 'en'])) {
            App::setLocale($locale);
        } else {
            App::setLocale(config('app.locale', 'ar'));
        }

        return $next($request);
    }
}
