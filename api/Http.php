<?php

class Http
{
    public static function response(array $response)
    {
        if (!is_int($response[0])) {
            throw new Exception("O código http deve ser um número.");
        }

        if (isset($response[1]) && !empty($response[1])) {
            echo json_encode([
                'status' => $response[0],
                'data' => $response[1]
            ]);
        }

        http_response_code($response[0]);
        die;
    }

}
