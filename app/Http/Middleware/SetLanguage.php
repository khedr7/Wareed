<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLanguage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $lang = request()->header('lang') ?? 'en';

        App::setLocale($lang);

        if (Auth::user()) {
            $user = User::where('id', Auth::user()->id)->first();
            if ($user->app_lang != $lang) {
                $user->app_lang = $lang;
                $user->save();
            }
        }

        return $next($request);
    }
}
