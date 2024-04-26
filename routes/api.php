<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\signupController;
use App\Http\Controllers\signinController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', [signinController::class , 'getUserByToken']);

// Route::get('/signup',function()
// {
// return 'hi fr0m api';
// });
Route::get('signup', [signupController::class, 'usersshow']);
Route::post('signup', [signupController::class, 'signup']);
Route::fallback(function () {
    return response()->json(['message' => 'Not Found'], 404);
});

// In routes/api.php
Route::post('signin', [signinController::class, 'signin']);

// In routes/web.php





// // Registration and Authentication
// Route::post('/register', [UserController::class, 'register']);

// Route::post('/signin', [UserController::class, 'signin']);
// Route::get('/signin', [UserController::class, 'showsigninForm'])->name('signin');


// // User Routes

   // Route::get('/userhome', [UserController::class, 'userHome'])->middleware('auth');
    Route::get('/viewmymatches',  [UserController::class, 'viewMyMatches']);
    Route::get('/viewprofile', [UserController::class, 'viewProfile']);
    Route::group(['middleware' => ['auth', 'checkRole:1']], function () {
    Route::delete('/trainerhomepage', [UserController::class, 'deleteuser'])->name('deleteuser');
    });
    

   
// // Match Routes

   Route::get('/viewallmatches', [MatchController::class, 'viewallmatches']);

    Route::post('/match/create', [MatchController::class, 'creatematch']); ////////////////////////////////////err0r
    Route::get('/creatematch', [MatchController::class, 'showcreatematch']);

    Route::get('/match/{id}', [MatchController::class, 'show']);
    Route::post('/match/{id}/adduser', [MatchController::class, 'addUsertoMatch']);

    Route::get('/adduser', [UserController::class, 'showadduserForm'])->name('adduser');
    Route::post('/adduser', [UserController::class, 'register'])->name('adduser');


//     //view each match page according id : 
    Route::post('/match/{id}', [MatchController::class,'removeuserfrommatch'])->name('showmatch');
    Route::get('/match/{id}', [MatchController::class,'show']);



    Route::post('/match/{id}/removeuser', [MatchController::class, 'removeUserFromMatch']);
    Route::post('/match', [MatchController::class,'addUsertoMatch']);
    //Route::post('/match/removeuser', [MatchController::class,'removeUserFromMatch']);

    Route::get('/backtrainerhomepage', [UserController::class, 'backtrainerhomepage']);


    Route::post('login', [signinController::class, 'login']);

   

//log out 

// Route::post('/logout', [SignInController::class, 'logout'])->name('logout');
