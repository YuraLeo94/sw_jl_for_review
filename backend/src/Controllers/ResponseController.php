<?php

namespace Controllers;


class ResponseController
{

    // function __construct()
    // {
    // }

    static function response(array $response)
    {
        header("Content-Type: application/json"); // withou it save get req to PC only when test server
        echo json_encode($response);
    }

    //Ping Dima today 05.05.2024
    // function setResponse(array $response) {
    //     echo json_encode($response);
    // }


    static function getPreparedDataResponseFailed(string $message): array
    {
        return [
            RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['failed'],
            RESPONSE_NAMES['messagesKeyName'] => $message
        ];
    }

    static function getPreparedDataResponseSuccess(string $message): array
    {
        return [
            RESPONSE_NAMES['statusKeyName'] => RESPONSE_NAMES['success'],
            RESPONSE_NAMES['messagesKeyName'] => $message
        ];
    }
}
