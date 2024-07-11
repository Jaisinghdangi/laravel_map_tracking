<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('loginId')) {
          //  return back();
           // return redirect('login')->with('fail','You have to login first.');
            return redirect()->route('auth.login')->with('success','You are Logged out. Plz Login Again!');

        }
        return $next($request);
    }
}
