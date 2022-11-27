<?php

namespace App\Services;


class ResponseGenerator
{
    
    public static function generateResponse($message, $code=200)
    {
        return array(
            'status' => $code,
            'message' => $message
        );
    }
}
