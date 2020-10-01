<?php

class Route
{
    private $uri;

    public function __construct($uri)
    {
        $route = explode("/", $uri);
        $route = array_diff($route, ['', 'endpointYT']);
        $route = array_values($route);

        $this->uri = !empty($route) ? $route[0] : null;
    }

    public function redirect($method)
    {
        $endpoint = $this->uri;

        if (strpos($this->uri, '?')) {
            $endpoint = substr($this->uri, 0, strpos($this->uri, '?'));
        }

        switch ($endpoint) {
            case 'search':
                $search = new Search($this->uri);
                return $search->getResponse($method);
                break;
            default:
                return [404];
                break;
        }
    }
}
