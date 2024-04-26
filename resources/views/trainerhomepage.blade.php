<!DOCTYPE html>
<h1>Trainer home page </h1>
<head>
    <link rel="stylesheet" href="{{asset('css/trainerhomepage.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="jwt-token" content=""> --}}

</head>
<body>
<div>
  
    <p>User ID: {{ auth()->id() }}</p>
    {{--  --}}
    <a  class="btn" id="addUserBtn" href="/adduser">Add User</a>
    {{-- <a href="/creatematch" class="btn">Create Match</a> --}}
    {{--  --}}
    <a  class="btn" id="createMatchBtn" href="/creatematch" id="createMatchBtn">Create Match</a>
    {{-- href="/viewallmatches"  --}}
    <a class="btn" id="viewAllMatchesBtn" >View all Matches</a>
    <form method="GET" action="{{ route('logout') }}">
      @csrf
      <button type="submit">Logout</button>
    </form>
</div>
@if (Session::has('success'))
    <div class="alert" role="alert">
    {{Session::get('success')}}
    </div>
    @endif
<div class="container">
  <h1>All Users</h1>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Email</th>
        <th>Role</th>
        
      </tr>
    </thead>
    <tbody>
      @foreach($users as $user)
      <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->firstname }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->role == 0 ? 'Player' : 'Trainer' }}</td>    
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<form id="deleteuser" class="container">
  @csrf
  @method('DELETE')
  <h1>Delete User</h1>
  <label for="email">Email</label>
  <input type="email" id="email" name="email" onblur="validateEmail()" required>
  <p id="emailValidationMessage"></p>
  <button type="submit" class="deletebtn">Delete</button>
</form>
<div id="deleteResult"></div>

<script>
  document.getElementById('deleteuser').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);
    fetch('/trainerhomepage', {
        method: 'POST',
        body: formData,
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('tokenjwt')
        }
    })
    .then(response => response.json())
    .then(data => {
        var createResultDiv = document.getElementById('deleteResult');
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