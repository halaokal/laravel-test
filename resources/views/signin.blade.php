<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/signin.css') }}">
</head>
<body>
    @if (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
    @endif
    <a href="http://127.0.0.1:8000/home">Back</a></span>

    <form id="signin-form" method="POST">
        @csrf
        <div class="container">
            <h1>Login</h1>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com"><br>

            <label for="password">Password</label>
            <input type="password" id="password" name="password"><br>
            <button type="submit" class="registerbtn">Log in</button>
            <span>Don't have an account? <a href="http://127.0.0.1:8000/register">Sign up</a></span>
        </div>
    </form>

    <div id="error-container"></div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        var trainerHomepageUrl = '{{ url("/trainerhomepage") }}';
        var playerHomepageUrl = '{{ url("/playerhomepage") }}';
    </script>
    


    <script>
    $(document).ready(function () {
        $('#signin-form').submit(function (event) {
            event.preventDefault(); // Prevent the default form submission
    
            // Get form data
            var formData = {
                email: $('#email').val(),
                password: $('#password').val(),
                _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
            };
    
            // Send AJAX POST request to the signin API
            $.ajax({
                type: 'POST',
                url: '/signin', // Change the URL to your API endpoint
                data: formData,
                dataType: 'json',
                encode: true,
                    headers: {
                     'Authorization': 'Bearer ' + localStorage.getItem('tokenjwt')
                    },
                
                success: function (response) {
                    // Handle successful response
                    var token = response.authorisation.tokenjwt;
                    // console.log("token is : "+token);
                    localStorage.setItem('tokenjwt', token); // Store token in localStorage
    
                    // Redirect to appropriate page based on user role
                    var decodedToken = parseJwt(token);
                    var userRole = decodedToken.role;
                    if (userRole == 1) {
                        window.location.href = "/trainerhomepage"; // Redirect to trainer home
                    } else {
                        window.location.href = "/playerhomepage"; // Redirect to player home
                    }
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    var errorMessage = xhr.responseJSON.error;
                    $('#error-container').text(errorMessage);
                }
            });
        });
    });
    
    function parseJwt(token) {
        var base64Url = token.split('.')[1];
        var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
            return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        }).join(''));
    
        return JSON.parse(jsonPayload);
    }

    </script>
    
</body>
</html>
