<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign up</title>
<link rel="stylesheet" href="{{asset('css/match.css')}}">
</head>
<body>
@if (Session::has('success'))
<div class="alert" role="alert">
{{Session::get('success')}}
</div>
@endif
<a href="/backtrainerhomepage">Back</a>
<div class="container">
    <p>User ID: {{ auth()->id() }}</p>
    <h1>All Matches</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Date</th>
                <th>Location</th>
                <th>Trainer</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matches as $match)
            <tr>
                <td>{{ $match->id }}</td>
                <td>{{ $match->name }}</td>
                <td>{{ $match->date }}</td>
                <td>{{ $match->location }}</td>
                <td>{{ $match->trainer->firstname }}</td>
                <td>
                    <form action="{{ url('/api/match/'. $match->id) }}" method="GET">
                        <button class="btn btn-primary" type="submit">Show Match</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<form method="POST" id="creatematch">
    @csrf

    <div class="container">
        <h1>Create new match</h1>
        <label for="name">Match Name:</label>
        <input type="text" class="form-control" id="name" name="name">

        <label for="date">Match Date:</label>
        <input type="datetime-local" class="form-control" id="date" name="date">


        <label for="location">Match Location:</label>
        <input type="text" class="form-control" id="location" name="location">

        <button type="submit" class="btn btn-primary">Create Match</button>
    </div>
</form>
<div id="createResult"></div>

<script>
document.getElementById('creatematch').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    fetch('/creatematch', {
        method: 'POST',
        body: formData,
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('tokenjwt')
        }
    })
    .then(response => response.json())
    .then(data => {
        var createResultDiv = document.getElementById('createResult');
        if (data.success) {
            createResultDiv.innerHTML = '<div class="success">' + data.success + '</div>';
        } else if (data.error) {
            createResultDiv.innerHTML = '<div class="error">' + data.error + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>

</body>
</html>
