<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\signinController;

use App\Http\Middleware\AuthenticateMiddleware;
use App\Models\MatchUserModel;

// Route::get('/matches', [MatchController::class, 'showpagenatefile']);
Route::get('/matches', [MatchController::class, 'index']);
Route::get('/users/{userId}/matches', [MatchController::class, 'getUserMatches']);
Route::get('/matches/{matchId}/users', [MatchController::class, 'getMatchUsers']);


//view trainer home page : 
//Route::get('/trainerhomepage', [UserController::class, 'showTrainerHomepage'])->name('trainerhomepage')->middleware('authe');

// Route::get('/trainerhomepage', function () {
//     return view('trainerhomepage');
// })->name('trainerhomepage')->middleware('authe');

// //view player home page : 
// Route::get('/playerhomepage', function () {
//     return view('playerhomepage');
// })->name('playerhomepage');

Route::get('/home', function () {
    return view('home');
});


//database connection
Route::get('/db',function()
{
return view('dblaravel');
})->middleware('auth');

//registration form
// Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register');

//sign in form
Route::post('/signin', [UserController::class, 'signin'])->name('signin');
Route::get('/signin', [UserController::class, 'showsigninForm'])->name('signin')->middleware('preventSignInIfAuthenticated');

Route::get('/adduser', [UserController::class, 'showadduserForm'])->name('adduser');


Route::group(['middleware' => ['auth', 'checkRole']], function () {
    
Route::get('trainerhomepage', function () {
    return view('trainerhomepage');
})->name('trainerhomepage');//->middleware('Auth');

Route::post('/adduser', [UserController::class, 'register'])->name('adduser');



Route::delete('/trainerhomepage', [UserController::class, 'deleteuser'])->name('deleteuser');
Route::post('/trainerhomepage', [UserController::class, 'deleteuser'])->name('deleteuser');

Route::post('/creatematch', [MatchController::class, 'creatematch'])->name('creatematch');


});


Route::get('/creatematch', [MatchController::class, 'showcreatematch'])->name('creatematch');

Route::get('/viewallmatches', [MatchController::class, 'viewallmatches'])->name('viewallmatches');

//view player home page : 
Route::get('playerhomepage', function () {
    return view('playerhomepage');
})->name('playerhomepage');//->middleware('Auth');


//add user

//delete user route
Route::get('/trainerhomepage', [UserController::class, 'backtrainerhomepage'])->name('backtrainerhomepage');


//view create match page : 

//view each match page according id : 
Route::post('/match/{id}', [MatchController::class,'removeuserfrommatch'])->name('showmatch');
Route::get('/match/{id}', [MatchController::class,'show'])->name('showmatch');

//remove user from match
Route::post('/match/remove-user', [MatchController::class,'removeUserFromMatch'])->name('remove_user_from_match');

//add user to match
Route::post('/match', [MatchController::class,'addUsertoMatch'])->name('add_player_to_match');


//return back to player page (userhome page)
Route::get('/userhome', [UserController::class, 'userHome'])->name('userhome');

//return back to trainer home page 
Route::get('/backtrainerhomepage', [UserController::class, 'backtrainerhomepage'])->name('backtrainerhomepage');

//view all matches after press ("view all matches")

//view user (player) matches according to his id
 Route::get('/viewmymatches',  [UserController::class, 'viewMyMatches'])->name('viewmymatches');

// //view player profile
Route::get('/viewprofile', [UserController::class, 'viewProfile'])->name('viewprofile');


//task2
Route::get('/weather', [WeatherController::class, 'getWeather']);

//Route::post('/logout', [SignInController::class, 'logout'])->name('logout');
Route::get('/logout', [SignInController::class, 'logout'])->name('logout');
Route::post('signin', [signinController::class, 'signin']);
Route::group(['middleware' => 'auth:api'], function () {
    // Define your API routes here
   
});





