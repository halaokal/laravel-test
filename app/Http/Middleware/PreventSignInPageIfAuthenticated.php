<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;



class PreventSignInPageIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
//     public function handle(Request $request, Closure $next): Response
// {
//     if (!Auth::check()) {
//         return $next($request);
//     }

//     $user = Auth::user();

//     if ($user->role == 1) {
//         return redirect('/trainerhomepage');
//     } elseif($user->role == 0) { 
//         return redirect('/playerhomepage');
//     }

//     return $next($request);
// }

public function handle(Request $request, Closure $next): Response
{

    // try {
    //     // Check if the user is authenticated via JWT
    //     $token = JWTAuth::parseToken()->authenticate();
    // } catch (\Exception $e) {
    //     // User is not authenticated, continue to the sign-in page
    //     return $next($request);
    // }

    // User is authenticated, redirect based on user's role
    // if ($token->role == 1) {
    //     // Admin
    //     return redirect('/trainerhomepage');
    // } elseif ($token->role == 0) {
    //     // User
    //     return redirect('/playerhomepage');
    // }


    // Check if the user is authenticated
    if (Auth::check()) {
        //$user = Auth::user();
        // User is authenticated, redirect back to the previous page
        return redirect()->back();
    }

    // User is not authenticated, continue to the sign-in page
    return $next($request);
}


}
