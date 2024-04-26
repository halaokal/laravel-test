<?php

namespace App\Http\Controllers;

use App\Models\MatchUserModel;
use App\Models\MatchModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    

    public function viewMyMatches()
    {
        $user = Auth::user();
        $matchIds = MatchUserModel::where('userid', $user->id)->pluck('matchid');
        $matches = MatchModel::whereIn('id', $matchIds)->get();
    
        return view('viewmymatches', compact('matches'));
    }
    public function userHome()
{
    return view('playerhomepage');
}

    public function backtrainerhomepage(){
        $users = User::all();
        return view('trainerhomepage', ['users' => $users]);
    }

    public function viewProfile()
{
    $user = auth()->user();
    return view('viewprofile', compact('user'));
}

   
    //show registration form
    public function showRegistrationForm()
    {
        return view('customerregistration');
    }

   //sign up 
    // public function register(Request $request)
    // {    //check request if valid
    //     $request->validate([
    //         'firstname' => 'required',
    //         'lastname' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => [
    //             'required',
    //             'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/',
    //         ],
    //         'gender' => 'required',
    //         'country' => 'required',
            
    //     ]);

    //     if (User::where('email', $request->email)->exists()) {
    //         return redirect()->back()->withInput()->withErrors(['email' => 'This email is already registered.']);
    //     }



    //     //create new user
    //     $defaultRole = 0;

    //     if ($request->trainerCode == 12345) {
    //         $defaultRole = 1; // Set role to 1 if trainer code is 12345
    //     }


    //     $user = new User();
    //     $user->firstname = $request->firstname;
    //     $user->lastname = $request->lastname;
    //     $user->email = $request->email;
    //     $user->password = Hash::make($request->password); // Hash the password
    //     $user->gender = $request->gender;
    //     $user->country = $request->country;
    //     $user->zipcode = $request->zipcode;
    //     $user->role = $defaultRole;
    //     $user->save();
    //     return back()->with('success', 'User registered successfully!');
    // }


public function register(Request $request)
{
    // check request if valid
    $request->validate([
        'firstname' => 'required',
        'lastname' => 'required',
        'email' => 'required|email|unique:users',
        'password' => [
            'required',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/',
        ],
        'gender' => 'required',
        'country' => 'required',
    ]);

    if (User::where('email', $request->email)->exists()) {
        return response()->json(['error' => 'This email is already registered.'], 400);
    }

    // create new user
    $defaultRole = 0;

    if ($request->trainerCode == 12345) {
        $defaultRole = 1; // Set role to 1 if trainer code is 12345
    }

    $user = new User();
    $user->firstname = $request->firstname;
    $user->lastname = $request->lastname;
    $user->email = $request->email;
    $user->password = Hash::make($request->password); // Hash the password
    $user->gender = $request->gender;
    $user->country = $request->country;
    $user->zipcode = $request->zipcode;
    $user->role = $defaultRole;
    $user->save();

    return response()->json(['success' => 'User registered successfully!']);
}




    //show sign in form
    public function showsigninForm()
    {
        return view('signin');
    }
   
//sign in
public function signin(Request $req)
{    
    $credentials = [
        'email' => $req->email,
        'password' => $req->password,
    ];

    if (Auth::attempt($credentials)) {
        $role = auth()->user()->role;
        if ($role == 1) {
            $users = User::all();
            return view('trainerhomepage',['users' => $users]); // Redirect trainer to trainer-home
        } elseif ($role == 0) {
            return view('playerhomepage'); // Redirect player to player-home
        }
    }

    return back()->with(['error' => 'Invalid credentials']);
}
//add user

public function showadduserForm()
{
     return view('adduser');
    //$message = "ShowAddUserForm"; // Custom message
    
    // You can adjust the status code and data returned as needed
    //return response()->json(['message' => $message], 200);
}
//delete user
public function showdeleteuserForm()
{
    return view('trainerhomepage')->with('success', 'User deleted successfully.');
}



// public function deleteuser(Request $req)
// {
//     // Validate the request data
//     $req->validate([
//         'email' => 'required|email', // Validate email field
//     ]);

//     // Extract the email from the request
//     $email = $req->input('email');

//     // Find the user with the given email
//     $user = User::where('email', $email)->first();

//     // If the user exists
//     if ($user) {
//         // Check if the user's role is not equal to 1 (assuming role 1 denotes trainers)
//         if ($user->role != 1) {
    
//             $matches = MatchUserModel::where('userid', $user->id)->get();
    
//             if ($matches->count() > 0) {
//                 return redirect()->back()->with('error', 'This user is registered in a match. You cannot delete them.');
//             }
//             // Delete the user
//             $user->delete();
//             return redirect()->back()->with('success', 'User deleted successfully.');
//         } else {
//             // User is a trainer, do not delete
//             return redirect()->back()->with('error', 'Trainers cannot be deleted.');
//         }
//     } 
//     else {
//         // User not found
//         return redirect()->back()->with('error', 'User not found.');
//     }
    
// }

public function deleteuser(Request $request)
{
    // Validate the request data
    $request->validate([
        'email' => 'required|email', // Validate email field
    ]);

    // Extract the email from the request
    $email = $request->input('email');

    // Find the user with the given email
    $user = User::where('email', $email)->first();

    // If the user exists
    if ($user) {
        // Check if the user's role is not equal to 1 (assuming role 1 denotes trainers)
        if ($user->role != 1) {
            $matches = MatchUserModel::where('userid', $user->id)->get();

            if ($matches->count() > 0) {
                return response()->json(['error' => 'This user is registered in a match. You cannot delete them.'], 400);
            }
            // Delete the user
            $user->delete();
            return response()->json(['success' => 'User deleted successfully.'], 200);
        } else {
            // User is a trainer, do not delete
            return response()->json(['error' => 'Trainers cannot be deleted.'], 400);
        }
    } else {
        // User not found
        return response()->json(['error' => 'User not found.'], 404);
    }
}





}


