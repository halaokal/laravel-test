<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MatchModel;
use App\Models\User;
use App\Models\MatchUserModel;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\MatchResource;
class MatchController extends Controller

{
    public function showpagenatefile()
    {
        $matches = MatchModel::all();
        return view('pagenateandfilter');
    }

    public function index(Request $request)
    {
        // Retrieve matches from the database and paginate them
        $matches = MatchModel::paginate(4); // Paginate with 4 matches per page

        return response()->json([
            'status' => 'success',
            'data' => MatchResource::collection($matches),
            'links' => [
                'prev' => $matches->previousPageUrl(),
                'next' => $matches->nextPageUrl(),
            ],
        ]);
    }

    public function getUserMatches(Request $request, $userId)
    {
        // Retrieve match IDs for the given user
        $matchIds = MatchUserModel::where('userid', $userId)->pluck('matchid');

        // Retrieve matches based on the match IDs and paginate with 4 matches per page
        $matches = MatchModel::whereIn('id', $matchIds)->paginate(4);

        // Return paginated matches as JSON response
        return response()->json($matches);
    }


    public function getMatchUsers(Request $request, $matchId)
    {
        // Retrieve user IDs for the given match
        $userIds = MatchUserModel::where('matchid', $matchId)->pluck('userid');

        // Retrieve users based on the user IDs
        $users = User::whereIn('id', $userIds)->paginate(1);//->get();

        // Return users as JSON response
        return response()->json($users);
    }


    
   
    public function viewallmatches(){
        $matches = MatchModel::all();
        return response()->json(['matches' => $matches], 200);
        // $matches = MatchModel::all();
        // return view('allmatches',['matches' => $matches]);
    }

    public function showcreatematch(){
        $matches = MatchModel::all();
        //return response()->json(['matches' => $matches], 200);
        return view('match',['matches' => $matches]);
    }

    public function creatematch(Request $request)
{
    
    // Validate form data
    $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'location' => 'required|string|max:255',
    ]);
    //$user = Auth::user();
    $user = auth()->user();
    //dd($user);

    // Create new match 
    $match = new MatchModel();
    $match->name = $request->name;
    $match->date = $request->date;
    $match->location = $request->location;
    $match->trainer_id = 36;
    $match->save();

    // Redirect to a confirmation page or wherever you want
   // return redirect()->route('creatematch')->with('success', 'Match created successfully!');
           return response()->json(['message' => 'Match created successfully'], 201);

}



public function show($id)
{
    // Retrieve match details based on match ID
    $match = MatchModel::findOrFail($id);
    
    // Retrieve player entries for the given match
    $matchUserEntries = MatchUserModel::where('matchid', $id)->get();
    
    // Retrieve player IDs
    $playerIds = $matchUserEntries->pluck('userid');
    
    // Retrieve users who are not already in this match
    $usersNotInMatch = User::whereNotIn('id', $playerIds)
                           ->where('role', 0) // Assuming role 0 represents players
                           ->get(['id', 'firstname', 'email']);
    
    // Retrieve user details (id, firstname, email) from the users table using the player IDs
    $players = User::whereIn('id', $playerIds)->get(['id', 'firstname', 'email']);
    
    return view('showmatch', compact('match', 'players', 'usersNotInMatch'));
}


public function removeUserFromMatch(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'match_id' => 'required|exists:matches,id',
    ]);

    $userId = $request->input('user_id');
    $matchId = $request->input('match_id');

    // Find the match user entry and delete it
    MatchUserModel::where('userid', $userId)
             ->where('matchid', $matchId)
             ->delete();

    return redirect()->back()->with('success', 'Player removed from match successfully.');
}

public function addUsertoMatch(Request $request){
    $request->validate([
        'userid' => 'required|exists:users,id',
        'matchid' => 'required|exists:matches,id',
    ]);

    $userId = $request->input('userid');
    $matchId = $request->input('matchid');
        $matchuser = new MatchUserModel();
        $matchuser->matchid = $request->matchid;
        $matchuser->userid=$request->userid;
        $matchuser->save();

    return redirect()->back()->with('add', 'Player added to the match successfully.');
}





}