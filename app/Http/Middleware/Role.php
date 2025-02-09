<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (Auth::check()) {
            if (Auth::user()->role === 'Admin') {
                return redirect()->route('home');
            } elseif (Auth::user()->role === 'Merchant') {
                return redirect()->route('merchants.dashboard');
            }
        }
        return $next($request);
    }
}
