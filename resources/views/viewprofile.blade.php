<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>

    <link rel="stylesheet" href="{{asset('css/viewprofile.css')}}">

</head>
<body>
    <div class="container">
        <a href="{{ route('userhome') }}" class="btn btn-primary">Back</a>
        <h1>User Profile</h1>
        <p><strong>First Name:</strong> {{ $user->firstname }}</p>
        <p><strong>Last Name:</strong> {{ $user->lastname }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Country:</strong> {{ $user->country }}</p>
        <p><strong>Role:</strong> {{ $user->role == 0 ? 'Player' : 'Trainer' }}</p>
    </div>
</body>
</html>