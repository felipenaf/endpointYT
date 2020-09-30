<?php

require_once 'vendor/autoload.php';

$route = new Route($_SERVER['REQUEST_URI']);
$response = $route->redirect($_SERVER['REQUEST_METHOD']);

if ($response[0]) {
    echo json_encode([
        'status' => $response[1],
        'data' => $response[0]
    ]);
}

http_response_code($response[1]);
// $curl = curl_init();

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://www.googleapis.com/youtube/v3/search?key=AIzaSyC0cg9KQgSg4oYeQLBrCnn60J1nQLRYoZc&maxResults=10&part=snippet&chart=mostPopular&q=php",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "GET",
// ));

// $response = curl_exec($curl);

// curl_close($curl);
// echo $response;
