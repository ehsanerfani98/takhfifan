<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user) {
            if ($user->hasRole('User')) {
                return redirect()->route('user.home');
            }

            if ($user->hasRole('Admin')) {
                return $next($request);
            }

            if ($user->hasRole('advisor')) {
                return $next($request);
            }

            return abort(403, 'دسترسی غیرمجاز');
        }

        return redirect()->route('login');
    }
}
