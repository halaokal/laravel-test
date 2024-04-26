<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Forecast</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .weather-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .weather-info {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="weather-container">
    <h1>Weather Forecast</h1>
    <div class="weather-info">
        @if(isset($weatherData['list']) && count($weatherData['list']) > 0)
            <?php
            $forecast = $weatherData['list'][0];
            $temperature = round($forecast['main']['temp'] - 273.15); // Convert temperature from Kelvin to Celsius
            $weatherDescription = $forecast['weather'][0]['description'];
            ?>
            <p>Current Temperature: {{$temperature}}°C</p>
            <p>Weather: {{$weatherDescription}}</p>
        @else
            <p>Unable to fetch weather data</p>
        @endif
    </div>
</div>
</body>
</html>
