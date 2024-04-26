<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherController extends Controller
{
    public function getWeather()
    {
        $apiKey = '64d68e3890d01f97434e80190bcb2a13';
        $lat = '32.232464'; // Latitude of Jerusalem
        $lon = '35.216526'; // Longitude of Jerusalem
        

        // $lat = '36.946674'; // Latitude of Turkey
        // $lon = '35.215511'; // Longitude of Turkey
        
        $apiUrl = "https://api.openweathermap.org/data/2.5/forecast?lat={$lat}&lon={$lon}&appid={$apiKey}";

        $client = new Client();
        try {
            $response = $client->get($apiUrl);
            $weatherData = json_decode($response->getBody(), true);
           // dd($weatherData);

            return view('weather', ['weatherData' => $weatherData]);
        } catch (\Exception $e) {
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}
