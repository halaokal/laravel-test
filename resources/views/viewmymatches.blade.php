<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('css/viewmymatches.css')}}">
</head>
<body>
    <a href="{{ route('userhome') }}" class="btn btn-primary">Back to Home</a>

    <div class="container">
        <h1>My Matches</h1>
        @foreach ($matches as $match)
        <div class="match-card">
            <h3>{{ $match->name }}</h3>
            <p>Date: {{ $match->date }}</p>
            <p>Location: {{ $match->location }}</p>
            <!-- Add more fields as needed -->
        </div>
        @endforeach
    </div>
</body>
</html>
