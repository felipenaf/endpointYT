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

                $curl = curl_init();
                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://www.googleapis.com/youtube/v3/search?key=AIzaSyC0cg9KQgSg4oYeQLBrCnn60J1nQLRYoZc&maxResults=10&part=snippet&chart=mostPopular&q=php",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $response = curl_exec($curl);
                curl_close($curl);

                $tt = json_decode($response, true);

                if ($tt['error']) {
                    Http::response($tt['error']['code'], $tt['error']['message']);
                }

                /* parei aqui */
                Http::_200($response);
            break;

            default:
                Http::response(405);
            break;
        }
    }
}
