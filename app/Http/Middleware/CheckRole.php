<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\JwtManager;
use Illuminate\Support\Facades\Log;


class CheckRole
{

    protected $jwtManager;

    public function __construct(JwtManager $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken(); // Retrieve JWT token from request headers
       // Log::info('JWT Token Received: ' . $token);
      // Log::info('JWT Token Received: ' . $token);

        //dd($token);
        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }                 

        $payload = $this->jwtManager->decodeToken($token);

        $userRole = $payload['role'] ?? null;

        if ($userRole != 1) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }























    // /**
    //  * Handle an incoming request.
    //  *
    //  * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
    //  */
    // public function handle(Request $request, Closure $next, ...$roles): Response
    // {
    //     $token = $request->bearerToken(); // Retrieve JWT token from request

    //     // If token is not present or invalid, return unauthorized
    //     if (!$token || !$this->isValidToken($token)) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     // Decode token to extract payload
    //     $payload = $this->decodeToken($token);

    //     // Check if the user's role is allowed for the requested route
    //     if (in_array($payload['role'], $roles)) {
    //         return $next($request);
    //     }

    //     return response()->json(['error' => 'Unauthorized'], 403);
    // }

    // private function isValidToken($token)
    // {
    //     $jwtManager = new JwtManager();
    //     return $jwtManager->validateToken($token);
    // }

    // // Decode token using JwtManager
    // private function decodeToken($token)
    // {
    //     $jwtManager = new JwtManager();
    //     return $jwtManager->decodeToken($token);
    // }
}
