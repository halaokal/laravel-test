<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="{{asset('css/adduser.css')}}">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add new user</title>
</head>
<body>
@if (Session::has('success'))
<div class="alert" role="alert">
{{Session::get('success')}}
</div>
@endif
<a href="/api/backtrainerhomepage">Back</a></span>
{{-- //action="/adduser" --}}
<form method="POST"   id="registrationForm">
  @csrf
    <div class="container">

        <h1>ADD User</h1>

        <label for="firstname">First name</label>
        <input type="text" id="firstname" name="firstname" ><br><br>
        <span class="required-label"></span>


        <label for="lastname">Last name</label>
        <input type="text" id="lastname" name="lastname"  ><br><br>
        <span class="required-label"></span>


        <label for="email">Email</label>
        <input type="email" id="email" name="email" onblur="validateEmail()"  ><br><br>
        <p id="emailValidationMessage"></p>

        <label for="password">password</label>
        <input type="password" id="password" name="password" onblur="validatePassword()"  ><br><br>
    
        <p id="validationMessage"></p>

        <label for="gender">Gender</label>
        <input type="radio" name="gender" id="Female" name="Female" value="Female" ><label>Female</label>
        <input type="radio" name="gender" id="male" name="male" value="male"><label>male</label> <br><br>

        <label for="country">Country</label>
        <select class="form-select" id="country" name="country">
            <option value="Palestine">Palestine</option>
            <option value="Jorden">Jorden</option>
            <option value="Lebanon">Lebanon</option>
            <option value="syria">syria</option>
        </select> <br><br>


        <label>Zip Code</label>
        <input type="text" name="zipcode" id="zipcode" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="5" ><br><br>
        
        <!-- Role checkbox button -->
        <input type="checkbox" id="roleButton" onchange="toggleNewFieldBasedOnRole()">
        <label for="roleButton">Trainer</label><br>
        
        <div id="trainerCodefeild">
            <label for="trainerCode">Trainer code:</label>
            <input type="text" id="trainerCode" name="trainerCode">
        </div>

        <button type="submit" class="registerbtn">Add user</button>
        <div id="addResult"></div>

        {{-- @if($errors->has('email'))
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif --}}

    </div>
</form>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
<script>


function toggleNewFieldBasedOnRole() {
    var checkbox = document.getElementById("roleButton");
    var field = document.getElementById("trainerCodefeild");

    // Check if the checkbox is checked and toggle the field accordingly
    if (checkbox.checked) {
        field.style.display = "block";
    } else {
        field.style.display = "none";
    }
}

function validatePassword() {
    var password = document.getElementById("password").value;
    var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/;
    
    if (!passwordRegex.test(password)) {
        document.getElementById("validationMessage").innerText = "Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, one number, and one of the following special characters: @#$^%&* d0nt use any 0f these : <>()\/\\|";
        document.getElementById("password").focus();
    } else {
        document.getElementById("validationMessage").innerText = "";
    }
}


function validateEmail() {
    var email = document.getElementById("email").value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        document.getElementById("emailValidationMessage").innerText = "Invalid email format.";
    } else {
        document.getElementById("emailValidationMessage").innerText = "";
    }
}

// document.querySelector('.registerbtn').addEventListener('click', function(event) {
document.getElementById('registrationForm').addEventListener('submit', function(event) {

    event.preventDefault(); // Prevent default button click behavior

    // Assuming you have a form with id 'addUserForm', you can get its data
    //var formData = new FormData(document.getElementById('addUserForm'));
    var formData = new FormData(this);

    fetch('/adduser', {
        method: 'POST',
        body: formData,
        headers: {
            'Authorization': 'Bearer ' + localStorage.getItem('tokenjwt')
        }
    })
    .then(response => response.json())
    .then(data => {
        // Handle the response
        var addResultDiv = document.getElementById('addResult');
        if (data.success) {
            addResultDiv.innerHTML = '<div class="success">' + data.success + '</div>';
        } else if (data.error) {
            addResultDiv.innerHTML = '<div class="error">' + data.error + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});


$(document).ready(function() {
    // $('#registrationForm').validate({
    //     rules: {
    //         firstname: {
    //             required: true
    //         },
    //         lastname: {
    //             required: true
    //         },
    //         email: {
    //             required: true,
    //             email: true
    //         },
    //         password: {
    //             required: true,
    //         },
    //         zipcode: {
    //             required: true,
    //             digits: true,
    //             minlength: 3,
    //             maxlength: 5
    //         },
    //         trainerCode:{
    //              required: {
    //                 depends: function() {
    //                     return $('#roleButton').is(':checked');
    //                 }
    //             }
    //         }
            
            
    //     },
    //     messages: {
    //         firstname: {
    //             required: "Please enter your first name."
    //         },
    //         lastname: {
    //             required: "Please enter your last name."
    //         },
    //         email: {
    //             required: "Please enter your email address.",
    //             email: "Please enter a valid email address."
    //         },
    //         password: {
    //             required: "Please enter a password."
                
    //         },
    //         zipcode: {
    //             required: "Please enter your zip code.",
    //             digits: "Please enter only digits.",
    //             minlength: "Please enter a valid 3-digit zip code.",
    //             maxlength: "Please enter a valid 5-digit zip code."
    //         },
    //         trainerCode:{
    //             required:"Enter your code"
    //         }
    //     },
        // submitHandler: function(form) {
        //     form.submit();
        // }
    });
//});

</script>
