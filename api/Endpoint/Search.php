<?php

class Search
{
    private $mandatoryParameters = ['keyword'];
    private $uri;
    private $parameters = [];

    public function __construct($uri)
    {
        if (!strpos($uri, '?')) {
            Http::response(422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.');
        }

        $uri = explode('?', $uri);

        foreach ($uri as $key => $stringParameter) {
            if ($key == 0) {
                continue;
            }

            $parameter = substr($stringParameter, 0, strpos($stringParameter, '='));

            if (!in_array($parameter, $this->mandatoryParameters)) {
                Http::response(422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.');
            }

            $parameterValue = substr($stringParameter, strpos($stringParameter, '=') + 1);
            if (strlen($parameterValue) == 0) {
                Http::response(422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.');
            }

            if (strlen($parameterValue) < 3 && $parameter == 'keyword') {
                Http::response(422, 'O parâmetro keyword deve conter no mínimo três caracteres.');
            }

            $this->parameters[$parameter] = $parameterValue;
        }

        $this->uri = implode('?', $uri);
    }

    public function getResponse($method)
    {
        switch ($method) {
            case 'GET':
                /* parei aqui */
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
                Http::response(405);
            break;
        }
    }
}
