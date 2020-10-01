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

    public static function _200($message)
    {
        echo $message;
        http_response_code(200);

        die;
    }

}
