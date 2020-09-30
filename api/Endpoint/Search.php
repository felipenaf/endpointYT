<?php

class Search
{
    public static function getResponse($uri, $method)
    {
        $uri = explode('?', $uri);
        $keyword = substr($uri[1], 0, strpos($uri[1], '='));

        if (!isset($uri[1]) || $keyword != 'keyword') {
            Http::_422('O parâmetro keyword é obrigatório.');
        }

        $parameter = substr($uri[1], strpos($uri[1], '=') + 1);
        if (strlen($parameter) < 3) {
            Http::_422('O parâmetro keyword deve conter no mínimo três caracteres.');
        }

        /* parei aqui */

        $parameter = isset($uri[1]) ? $uri[1] : '';
        $secondParameter = isset($uri[2]) ? $uri[2] : '';

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
