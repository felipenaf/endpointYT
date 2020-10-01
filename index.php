<?php

require_once 'vendor/autoload.php';

$route = new Route($_SERVER['REQUEST_URI']);
$response = $route->redirect($_SERVER['REQUEST_METHOD']);

Http::response($response);
