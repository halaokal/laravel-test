<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function register(Request $request)
    {
        // Validate form data
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'gender' => 'required|string|in:male,female', // Assuming only male and female options
            'country' => 'required|string',
            'zipcode' => 'required|string|max:255',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return redirect()->back()->withInput()->withErrors(['email' => 'This email is already registered.']);
        }
        // Create new user
        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Hash the password
            'gender' => $validatedData['gender'],
            'country' => $validatedData['country'],
            'zipcode' => $validatedData['zipcode'],
        ]);

        // Optionally, you can log in the user after registration
        // auth()->login($user);

        // Redirect the user to a success page or anywhere else
        return redirect()->route('home')->with('success', 'Registration successful!');
    }
}
