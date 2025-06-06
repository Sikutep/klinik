<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (! session()->has('user_id')) {

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            // return response()->json(['message' => 'Unauthorized'], 401);
            return redirect('/login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }
        return $next($request);
    }
}
