<?php

namespace frontend\models;


class ResponseBase
{

    public function response($code, $data = '', $hasValidationPassed = true)
    {
        $response = [];
        $message = $this->_getStatusCodeMessage($code);
        if (!$hasValidationPassed) {
            $response = [
                'status' => $code,
                'message' => $message,
                'response' => $data
            ];
        } else {
            $response = [
                'status' => $code,
                'message' => $message,
                'response' => $data
            ];
        }
        $this->_setHeader($code);
        echo json_encode($response);
        die();
    }

    private function _getStatusCodeMessage($status)
    {
        $codes = [
            //Success 2XX
            200 => 'OK',
            201 => 'Invalid',
            202 => 'Accepted',
            203 => 'Non Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            //Client Error 4XX
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity too large',
            414 => 'Request URI too long',
            415 => 'Unsupported Media type',
            416 => 'Request Range not satisfiable',
            417 => 'Expectation Failed',
            //Server Error 5XX
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavaialable',
            504 => 'Gateway timeout',
            505 => 'HTTP version not supported',
            509 => 'Bandwidth limit excedded'
        ];
        return (isset($codes[$status])) ? $codes[$status] : '';
    }

    private function _setHeader($status)
    {
        $status_header = 'HTTP/2 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type = "application/json; charset=utf-8";
        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Empower Youth");
    }
}