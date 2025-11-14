<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ưu tiên: ?lang=xx  → session
        if ($locale = $request->query('lang')) {
            session(['locale' => $locale]);
        }

        // Nếu có user và có cột locale trong users, ưu tiên user->locale
        $userLocale = optional(Auth::user())->locale;

        // Lấy theo thứ tự: user → session → fallback (vi)
        $active = $userLocale ?: session('locale', 'vi');

        App::setLocale($active);

        return $next($request);
    }
}
