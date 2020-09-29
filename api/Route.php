<?php

class Route
{
    private $uri;

    public function __construct($uri)
    {
        $route = explode("/", $uri);
        $route = array_diff($route, array('endpointYT'));

        $this->uri = array_values($route);
    }

    public function redirect($method)
    {
        switch ($this->uri[1]) {
            case 'search':
                require_once($_SERVER['DOCUMENT_ROOT'] . 'endpointYT/frontend/index.php');
                break;
            default:
                return ['', 404];
                break;
        }
    }
}
