<?php

require_once ("CurlCall.php");
require_once ("SocketCall.php");

/**
 * Created by PhpStorm.
 * User: home
 * Date: 1/20/18
 * Time: 11:23 AM
 */

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
    }

    public function setMethod(string $method) {
        $this->strategy->setMethod($method);
    }

    public function setContentType(string $contentType) {
        $this->strategy->setContentType($contentType);
    }

    public function setHeaders(array $headers) {
        $this->strategy->setHeaders($headers);
    }

    public function setJsonData(array $jsonData) {
        $this->strategy->setJsonData($jsonData);
    }

    public function send() {
       return $this->strategy->send();
    }
}