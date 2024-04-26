<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign up </title>
    <link rel="stylesheet" href="{{asset('css/customerregistration.css')}}">

</head>
<body>
@if (Session::has('success'))
<div class="alert" role="alert">
{{Session::get('success')}}
</div>
@endif
<form id="registrationForm" action="/api/signup">
  @csrf
  <a href="http://127.0.0.1:8000/home">Back</a></span>

    <div class="container">

        <h1> Registration Form</h1>

        <label for="firstname">First name</label>
        <input type="text" id="firstname" name="firstname" ><br><br>
        <!-- <span class="required-label"></span> -->


        <label for="lastname">Last name</label>
        <input type="text" id="lastname" name="lastname"  ><br><br>
        <!-- <span class="required-label"></span> -->


        <label for="email">Email</label>
        <input type="email" id="email" name="email" onblur="validateEmail()"  ><br><br>
        <!-- <p id="emailValidationMessage"></p> -->

        <label for="password">password</label>
        <input type="password" id="password" name="password" onblur="validatePassword()"  ><br><br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" onblur="validateConfirmPassword()">
        

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
        <label for="roleButton">I am Trainer</label><br>
        
        <div id="trainerCodefeild">
            <!-- This is the field that will be toggled based on role -->
            <label for="trainerCode">Trainer code:</label>
            <input type="text" id="trainerCode" name="trainerCode">
        </div>

        <button type="button" class="registerbtn" onclick="submitForm()">Sign up</button>
        <span>Already have an account? <a href="http://127.0.0.1:8000/signin">Log in</a></span>

        @if($errors->has('email'))
        <div class="alert alert-danger">{{ $errors->first('email') }}</div>
        @endif

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

function toggleNewFieldBasedOnRole() {
    var checkbox = document.getElementById("roleButton");
    var field = document.getElementById("trainerCodefeild");

    if (checkbox.checked) {
        field.style.display = "block";
    } else {
        field.style.display = "none";
    }
}

function submitForm() {
    var formData = {
        firstname: $('#firstname').val(),
        lastname: $('#lastname').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        confirmPassword: $('#confirmPassword').val(),
        gender: $('input[name=gender]:checked').val(),
        country: $('#country').val(),
        zipcode: $('#zipcode').val(),
        trainerCode: $('#trainerCode').val()
    };

    var isEmptyField = false;
    $('input[type=text], input[type=password], input[type=email], select').each(function() {
        if ($(this).prop('required') && $(this).val().trim() === '') {
            isEmptyField = true;
            return false;
        }
    });

    if (isEmptyField) {
        alert('Please fill in all required fields.');
        return;
    }

    $.ajax({
        type: 'POST',
        url: '/api/signup',
        data: formData,
        dataType: 'json',
        encode: true,
        success: function(response) {
            alert('User registered successfully');
            // Redirect or perform any other actions upon successful registration
        },
        error: function(xhr, status, error) {
            var errorMessage;
            if (xhr.status === 422) {
                errorMessage = "Validation error: ";
                $.each(xhr.responseJSON.error, function(key, value) {
                    errorMessage += value[0] + ' ';
                });
            } else {
                errorMessage = xhr.responseJSON.message;
            }
            alert('Error: ' + errorMessage);
        }
    });
}




// function validatePassword() {
//     var password = document.getElementById("password").value;
//     var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/;
    
//     if (!passwordRegex.test(password)) {
//         document.getElementById("validationMessage").innerText = "Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, one number, and one of the following special characters: @#$^%&* d0nt use any 0f these : <>()\/\\|";
//         document.getElementById("password").focus();
//     } else {
//         document.getElementById("validationMessage").innerText = "";
//     }
// }

// function validateConfirmPassword() {
//     var password = document.getElementById("password").value;
//     var confirmPassword = document.getElementById("confirmPassword").value;

//     if (password !== confirmPassword) {
//         document.getElementById("validationMessage").innerText = "Passwords do not match.";
//         document.getElementById("password").focus();
    
//     } else {
//         document.getElementById("validationMessage").innerText = "Passwords match.";
//     }
// }

// function validateEmail() {
//     var email = document.getElementById("email").value;
//     var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     if (!emailRegex.test(email)) {
//         document.getElementById("emailValidationMessage").innerText = "Invalid email format.";
//     } else {
//         document.getElementById("emailValidationMessage").innerText = "";
//     }
// }

$(document).ready(function() {
    $('#registrationForm').validate({
        // rules: {
        //     firstname: {
        //        // required: true
        //     },
        //     lastname: {
        //        // required: true
        //     },
        //     email: {
        //        // required: true,
        //         //email: true
        //     },
        //     // password: {
        //     //     required: true,
        //     //    // customPassword: true 
        //     // },
        //     // confirmPassword: {
        //     //     required: true,
        //     //    // equalTo: "#password"
        //     // },
        //     zipcode: {
        //        // required: true,
        //         //digits: true,
        //         //minlength: 3,
        //         //maxlength: 5
        //     },
        //     trainerCode:{
        //         //  required: {
        //         //     depends: function() {
        //         //         return $('#roleButton').is(':checked');
        //         //     }
        //         // }
        //     }
            
            
        // },
        // messages: {
        //     firstname: {
        //         required: "Please enter your first name."
        //     },
        //     lastname: {
        //         required: "Please enter your last name."
        //     },
        //     email: {
        //         required: "Please enter your email address.",
        //         email: "Please enter a valid email address."
        //     },
        //     // password: {
        //     //     required: "Please enter a password."
        //     // },
        //     // confirmPassword: {
        //     //     required: "Please confirm your password.",
        //     //     equalTo: "Passwords do not match."
        //     // },
        //     zipcode: {
        //         required: "Please enter your zip code.",
        //         digits: "Please enter only digits.",
        //         minlength: "Please enter a valid 3-digit zip code.",
        //         maxlength: "Please enter a valid 5-digit zip code."
        //     },
        //     trainerCode:{
        //         required:"Enter your code"
        //     }
        // },

        submitHandler: function(form) {
            form.submit();
        }
    });
    // $.validator.addMethod("customPassword", function(value, element) {
    //     var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$^%&*])[^\s<>()\/\\|]{8,}$/;
    //     return this.optional(element) || passwordRegex.test(value);
    // }, "Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, one number, and one of the following special characters: @#$^%&* ");
});

</script>
