<?php

class Search
{
    private $mandatoryParameters = ['q'];
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

            if (strlen($parameterValue) < 3 && $parameter == 'q') {
                Http::response(422, 'O parâmetro "q" deve conter no mínimo três caracteres.');
            }

            $this->parameters[$parameter] = $parameterValue;
        }

        $this->uri = implode('?', $uri);
    }

    public function getResponse($method)
    {
        switch ($method) {
            case 'GET':
                $youtube = new Youtube();
                $response = $youtube->search($this->parameters);
                $tt = http_response_code();

                if (isset($response['error'])) {
                    Http::response($response['error']['code'], $response['error']['message']);
                }

                if (empty($response['items'])) {
                    Http::response(204);
                }

                $newResponse = [];
                foreach ($response['items'] as $item) {
                    $snippet = $item['snippet'];

                    $arrayResponse['publishedAt'] = $snippet['publishedAt'];

                    if (isset($item['id']['videoId'])) {
                        $arrayResponse['videoId'] = $item['id']['videoId'];
                    } else {
                        $arrayResponse['channelId'] = $item['id']['channelId'];
                    }

                    $arrayResponse['title'] = $snippet['title'];
                    $arrayResponse['description'] = $snippet['description'];
                    $arrayResponse['thumbnail'] = $snippet['thumbnails']['high']['url'];
                    $arrayResponse['extra'] = [
                        'linkVideo' => isset($item['id']['videoId']) ? 'https://www.youtube.com/watch?v=' . $item['id']['videoId'] : '',
                        'linkChannel' => 'https://www.youtube.com/channel/' . $snippet['channelId'],
                        'publishTime' => $snippet['publishTime']
                    ];;

                    array_push($newResponse, $arrayResponse);
                }

                Http::response(200, $newResponse);
            break;

            default:
                Http::response(405);
            break;
        }
    }
}
