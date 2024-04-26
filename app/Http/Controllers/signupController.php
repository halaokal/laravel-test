<?php

namespace App\Http\Controllers;

use App\Http\Requests\signupRequest;
use Illuminate\Http\Request;
use App\Models\User;
//use Dotenv\Validator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class signupController extends Controller
{
    public function usersshow(){

        $student =User::all();
        $data=[
            'status'=>200,
            'student'=>$student
        ];
        return response()->json($data,200);
        
    }
    
    public function signup(Request $request)
{
    // Define custom error messages for validation
    $messages = [
        'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one digit, and one special character (@#$^%&*).',
        'confirmPassword.same' => 'The confirmation password must match the password field.',
    ];

    // Validate the request data with custom error messages
    $validator = Validator::make($request->all(), [
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique:users',
        'password' => [
            'required',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/',
        ],
        'confirmPassword' => 'required|same:password',
        'gender' => 'required',
        'country' => 'required',
    ], $messages);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // If validation passes, proceed with user creation
    $user = new User();
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->password = Hash::make($request->password);
    $user->gender = $request->gender;
    $user->country = $request->country;
    $user->zipcode = $request->zipcode;
    $user->role = 0;
    $user->save();

    $data = [
        'status' => 201, // Created
        'message' => 'User registered successfully'
    ];

    return response()->json($data, 201);
}


}
