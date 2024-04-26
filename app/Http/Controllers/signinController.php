<?php
// In SignInController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Session;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\Services\JwtManager;



class signinController extends Controller

{

//     public function signin(Request $request)
// {
//     $credentials = $request->only('email', 'password');

//     if (Auth::attempt($credentials)) {
//         $user = Auth::user();
//         $role = $user->role;

//         //$token = $user->createToken("API TOKEN")->plainTextToken;

//         if ($role == 1) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'User Logged In Successfully',
//                 //'token' => $token,
//                 'role' => 'trainer'
//             ], 200)->header('Location', '/trainerhomepage'); // Redirect to trainer homepage
//         } elseif ($role == 0) {
//             return response()->json([
//                 'status' => true,
//                 'message' => 'User Logged In Successfully',
//                 //'token' => $token,
//                 'role' => 'player'
//             ], 200)->header('Location', '/playerhomepage'); // Redirect to player homepage
//         }
//     }

//     // If authentication fails, return error message
//     return response()->json(['error' => 'Invalid credentials'], 401);
// }
    // public function signin(Request $request)
    // {
        
    //     $credentials = $request->only('email', 'password');
    //     $user = User::where('email',$request->email)->first();

    //     if (Auth::attempt($credentials)) {
    //         $user = Auth::user();
    //         //dd($user->id);
    //         $role = $user->role;
    //         $request->session()->regenerate();


    //         if ($role == 1) {
    //             $users = User::all();
    //             //$request->session()->regenerate();

    //             return view('trainerhomepage',['users' => $users]); // Redirect trainer to trainer-home
    //         } elseif ($role == 0) {
    //             return view('playerhomepage'); // Redirect player to player-home
    //         }
    //     }
        


    //     // If authentication fails, redirect back with error message
    //     return back()->with(['error' => 'Invalid credentials']);
    // }





    public function signin(Request $request)
{
    $credentials = $request->only('email', 'password');
    $user = User::where('email', $request->email)->first();

    // if (Auth::attempt($credentials)) {
    //     $user = Auth::user();
    //     $role = $user->role;
    //     $request->session()->regenerate();
    //     //$token = JWTAuth::fromUser($user);
    //     //$token = JWTAuth::claims(['role' => $user->role])->attempt($credentials);
    //         $users = User::all();
    //         return response()->json(['message' => 'Logged in as Trainer', 'role' => $user->role, 'users' => $users]);
    //     // } else {
    //     //     return response()->json(['message' => 'Logged in as Player', 'role' => $user->role]);
    //     // }
    // }

    $role = $user->role;
    $users = User::all();
    $token = Auth::attempt($credentials);
    $user = Auth::user();

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        }

        $jwtManager = new JwtManager(config('app.jwt_secret'));
        $tokenjwt = $jwtManager->createToken(['user_id' => $user->id, 'email' => $user->email,'role' => $user->role]);

        return response()->json([
                'status' => 'success',
                'user' => $user,
                'users' => $users,
                'role' => $user->role,
               // 'tokenjwt' => $tokenjwt,
                'authorisation' => [
                    'tokenjwt' => $tokenjwt,
                    'type' => 'bearer',      
                ]
            ]);




    // If authentication fails, return error message
   // return response()->json(['error' => 'Invalid credentials'], 401);
}



//     public function getUserByToken(Request $request)
// {
//     $user = $request->user(); // Get the authenticated user

//     // Now you can use the $user variable to access user information
//     if ($user) {
//         return response()->json(['user' => $user], 200);
//     } else {
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }
// }


public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/signin');
    }
    


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(compact('token'));
    }
}
