<!DOCTYPE html>
<h1>Player home page </h1>
@if (Session::has('success'))
<div class="alert" role="alert">
{{Session::get('success')}}
</div>
@endif
<head>
    <link rel="stylesheet" href="{{asset('css/playershomepage.css')}}">

</head>
<body>
<div>
    <p>User ID: {{ auth()->id() }}</p>

    {{-- <p>ssesion id :{{Session::get('id')}}</p> --}}
    <a  href="{{ route('viewprofile') }}" class="btn">View My Profile</a>
    <a href="{{ route('viewmymatches') }}" class="btn">View My Matches</a>
    {{-- <p> {{$authToken}}</p> --}}
</div>
<form method="GET" action="{{ route('logout') }}">
    @csrf
    <button type="submit">Logout</button>
</form>
</body>