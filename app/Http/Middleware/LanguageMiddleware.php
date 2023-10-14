<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $langs = Config::get("app.langs");
        $requestLang = $request->locale;

        if (in_array($requestLang, $langs)) {
            app()->setLocale($requestLang);
        } else {
            // if ($request->locale != "admin") {
            // $defautlLang = Config::get("app.default_locale");
            $defaultLang = Config::get("app.locale");
            app()->setLocale($defaultLang);

            $url = $request->fullUrl();

            $url = str_replace($requestLang, $defaultLang, $url);
            return redirect($url);
            // }
        }
        // dd("swdasdas");


        return $next($request);
    }
}
