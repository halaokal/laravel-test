<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Match Details</title>
    <link rel="stylesheet" href="{{asset('css/showmatch.css')}}">

</head>
<body>
    <a href='/api/creatematch' class="btn">Back</a>

    <div class="container">
        <h1>Match Details</h1>
        <table>
            <tr>
                <th>ID</th>
                <td>{{ $match->id }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>{{ $match->name }}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{ $match->date }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ $match->location }}</td>
            </tr>
            <tr>
                <th>Trainer</th>
                <td>{{ $match->trainer->firstname }}</td>
            </tr>
        </table>
        <h2>Players</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)
                <tr>
                    <td>{{ $player->id }}</td>
                    <td>{{ $player->firstname }}</td>
                    <td>{{ $player->email }}</td>
                    <!-- Add more columns if needed -->
                </tr>
                @endforeach
            </tbody>
        </table>
        <br><br>
        @if (Session::has('success'))
        <div class="alert" role="alert">
        {{Session::get('success')}}
        </div>
        @endif
        <form method="POST" action="{{ url('/api/match/' . $match->id . '/removeuser') }}">
            @csrf 
            <label for="user_id">User ID</label>
            <input type="text" id="user_id" name="user_id"><br><br>
            <input type="hidden" name="match_id" value="{{ $match->id }}"> 
            <button class="btn btn-primary" type="submit">Delete Player</button>
        </form>

        @if (Session::has('add'))
        <div class="alert" role="alert">
        {{Session::get('add')}}
        </div>
@endif

        <form method="POST" action="/api/match" id="addPlayerForm">
            
            @csrf
            <label for="userid">Select Player</label>
            <select id="userid" name="userid">
                @foreach ($usersNotInMatch as $user)
                    <option value="{{ $user->id }}">{{ $user->firstname }}</option>
                @endforeach
            </select>
            <input type="hidden" name="matchid" value="{{ $match->id }}"> 
            <button class="btn btn-primary" type="submit">Add Player</button>
        </form>
        
        <script>
            document.getElementById('addPlayerForm').addEventListener('submit', function(event) {
            var selectedValue = document.getElementById('userid').value;
            console.log(selectedValue);
            this.submit(); 
            event.preventDefault(); 
});

        </script>
        

        
   
</body>
</html>
