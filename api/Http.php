<?php

class Http
{
    public static function response($code, $message = '')
    {
        if ($message) {
            echo json_encode([
                'status' => $code,
                'data' => $message
            ]);
        }

        http_response_code($code);
        die;
    }

}
