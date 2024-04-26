<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Club Management System</title>
    <style>
        /* Provided CSS styles */
        #trainerCodefeild {
            display: none;
        }
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f2f2f2; /* Set background color */
            margin: 0;
            padding: 0;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .container {
            width: 50%;
            margin: 0 auto;
        }
        h1 {
            margin-bottom: 20px;
            font-size: 2.5em; /* Adjusted font size */
            color: #333; /* Changed color */
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        button.registerbtn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        button.registerbtn:hover {
            background-color: #0056b3;
        }
        /* End of provided CSS styles */
        /* Additional CSS for the home page */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Match button background color */
            color: white;
            text-decoration: none;
            font-size: 1.2em;
            border-radius: 5px;
            margin: 10px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3; /* Darker color on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sport Club Management System</h1>
        <a href="http://127.0.0.1:8000/register" class="btn">Sign Up</a>
        <a href="http://127.0.0.1:8000/signin" class="btn">Log in</a>
    </div>
</body>
</html>
