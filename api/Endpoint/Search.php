<?php

class Search
{
    public static function getResponse($uri, $method)
    {
        $parameter = isset($uri[1]) ? $uri[1] : '';
        $secondParameter = isset($uri[2]) ? $uri[2] : '';
        $userController = new UserController();

        switch ($method) {
            case 'GET':
                if (!empty($parameter)) {
                    if (is_numeric($parameter)) {
                        return $userController->getById($parameter);
                    }

                    return [null, 400];
                } else {
                    return $userController->getAll();
                }

                return [null, 404];
            break;

            default:
                return [null, 405];
            break;
        }
    }
}
