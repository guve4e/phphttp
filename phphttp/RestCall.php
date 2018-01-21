<?php

require_once ("CurlCall.php");
require_once ("SocketCall.php");

final class RestCall
{
    private $strategy = NULL;

    public function __construct(string $restCallType)
    {
        switch ($restCallType)
        {
            case "Curl":
                $this->strategy = new CurlCall();
                break;
            case "Socket":
                $this->strategy = new SocketCall();
                break;
        }
    }

    public function setUrl(string $url) {
         $this->strategy->setUrl($url);
         return $this;
    }

    public function setMethod(string $method) {
        $this->strategy->setMethod($method);
        return $this;
    }

    public function setContentType(string $contentType) {
        $this->strategy->setContentType($contentType);
        return $this;
    }

    public function setHeaders(array $headers) {
        $this->strategy->setHeaders($headers);
        return $this;
    }

    public function setJsonData(array $jsonData) {
        $this->strategy->setJsonData($jsonData);
        return $this;
    }

    public function send() {
       return $this->strategy->send();
    }

    public function isWaitingForResponse(bool $waiting)
    {
        return $this->strategy->isWaitingForResponse($waiting);
    }
}