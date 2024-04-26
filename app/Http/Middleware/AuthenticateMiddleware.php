<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddleware
{
    public function handle(Request $request, Closure $next,$guard = null)
{
    if (!Auth::check()) {
        return redirect('/signin');
    }
    
    $user = Auth::user();
    if ($user->role != 1) {
        // Normal user, redirect them or show an error page
        return redirect()->back()->with('error', 'You are not authorized to access this page.');
    }

    if (Auth::guard($guard)->check()) {
        return redirect('/home'); // Redirect to home page if user is already authenticated
    }


    return $next($request); // Redirect to some default page if the user doesn't have access
}

}
