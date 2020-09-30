<?php

class Http
{
    public static function _404($message = '')
    {
        if ($message) {
            echo json_encode([
                'status' => 404,
                'data' => $message
            ]);
        }

        http_response_code(404);
        die;
    }

    public static function _422($message = '')
    {
        if ($message) {
            echo json_encode([
                'status' => 402,
                'data' => $message
            ]);
        }

        http_response_code(402);
        die;
    }
}
