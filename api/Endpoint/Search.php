<?php

class Search
{
    private $mandatoryParameters = ['q'];
    private $uri;
    private $parameters = [];

    public function __construct($uri)
    {
        if (!strpos($uri, '?')) {
            return [422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.'];
        }

        $uri = explode('?', $uri);

        foreach ($uri as $key => $wholeParameter) {
            if ($key == 0) {
                continue;
            }

            foreach (explode('&', $wholeParameter) as $stringParameter) {
                $parameterValue = substr($stringParameter, strpos($stringParameter, '=') + 1);
                if (strlen($parameterValue) == 0) {
                    return [422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.'];
                }

                $parameter = substr($stringParameter, 0, strpos($stringParameter, '='));

                if (strlen($parameterValue) < 3 && $parameter == 'q') {
                    return [422, 'O parâmetro "q" deve conter no mínimo três caracteres.'];
                }

                if (in_array($parameter, $this->mandatoryParameters)) {
                    $pos = array_search($parameter, $this->mandatoryParameters);
                    unset($this->mandatoryParameters[$pos]);
                }

                $this->parameters[$parameter] = $parameterValue;
            }

        }

        if (!empty($this->mandatoryParameters)) {
            return [422, 'Os parâmetros ['. implode(',', $this->mandatoryParameters) .'] são obrigatórios.'];
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
                    return [$response['error']['code'], $response['error']['message']];
                }

                if (empty($response['items'])) {
                    return [204];
                }

                $newResponse = [];
                foreach ($response['items'] as $item) {
                    $snippet = $item['snippet'];

                    $arrayResponse['publishedAt'] = $snippet['publishedAt'];

                    if (isset($item['id']['videoId'])) {
                        $arrayResponse['videoId'] = $item['id']['videoId'];
                    }

                    if (isset($item['id']['channelId'])) {
                        $arrayResponse['channelId'] = $item['id']['channelId'];
                    }

                    if (isset($item['id']['playlistId'])) {
                        $arrayResponse['playlistId'] = $item['id']['playlistId'];
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

                return [200, $newResponse];
            break;

            default:
                return [405];
            break;
        }
    }
}
