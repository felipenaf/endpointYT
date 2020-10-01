<?php

class Youtube
{
    private $url = 'https://www.googleapis.com/youtube/v3/';
    private $key;

    public function __construct()
    {
        $configYoutube = parse_ini_file('config/youtube.ini');
        $this->key = '?key=' . $configYoutube['key'];
    }

    public function search($parameters)
    {
        $url = $this->url . 'search' . $this->key ."&maxResults=10&part=snippet&chart=mostPopular";

        foreach($parameters as $key => $parameter) {
            $url .= '&' . $key . '=' . $parameter;
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
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

        return json_decode($response, true);
    }
}
