<?php

namespace Helpers;

class Response
{
    private static $instance = null;
    private $statusCode;
    private $message;
    private $dataResponse;

    public function __construct()
    {
        $this->statusCode = null;
        $this->message = null;
        $this->dataResponse = null;
    }

    private function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    private function setMessage($message)
    {
        $this->message = $message;
    }

    private function setData($dataResponse)
    {
        $this->dataResponse = $dataResponse;
    }

    private static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function ServerResponse ($statusCode, $message, $data = null)
    {
        $serverResponse = self::getInstance();
        $serverResponse->setStatusCode($statusCode);
        $serverResponse->setMessage($message);
        if($data != null )
        {
            $serverResponse->setData($data);
        }else{
            $serverResponse->setData(null);
        }
        $serverResponse->sendResponse();
        die();
    }

    private function sendResponse()
    {
        header('Content-Type: application/json');
        http_response_code($this->statusCode);
        $respuesta = [
            'mensaje' => $this->message,
        ];
        if ($this->dataResponse !== null) {
            $respuesta['datos'] = $this->dataResponse;
        }
        echo json_encode($respuesta);
    }

    public function __clone()
    {
        trigger_error('La clonación de este objeto no está permitida', E_USER_ERROR);
    }
}
