<?php

class SocketCall extends HttpRequest
{

    private $port = 80;

    private $response = null;

    /**
     * @param int $port
     */
    public function setPort(int $port): void
    {
        $this->port = $port;
    }

    /**
     * SocketCall constructor.
     */
    function __construct() {
        $this->response = new RestResponse();
    }


    /**
     * Static constructor / factory
     */
    public static function create() : SocketCall
    {
        $instance = new self();
        return $instance;
    }

    public function send() : RestResponse
    {
        $data = $this->jsonData;

        $parts = parse_url($this->url);

        $this->startTime = $this->takeTime();

        $fp = fsockopen($parts['host'], $this->port, $errno, $errstr, 30);

        if (!$fp) throw new Exception("$errstr {$errno}\n");


        $out = "{$this->method} " . $parts['path'] . " HTTP/1.1\r\n";
        $out .= "Host: ". $parts['host'] . "\r\n";
        $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $out .= "Content-Length: " . strlen($data)."\r\n";
        $out .= "Connection: Close\r\n\r\n";
        $out .= $data;

        fwrite($fp, $out);

        $contents = "";

        //Waits for the web server to send the full response. On every line returned we append it onto the $contents
        //variable which will store the whole returned request once completed.
        while (!feof($fp)) {
            $contents .= fgets($fp, 4096);
        }

        $this->endTime = $this->takeTime();

        fclose($fp);

        $res = $this->retrieveRestResponseInfo($contents);

        return $res;
    }

    /**
     * Makes Rest Response Object
     * @param $response
     * @return RestResponse
     */
    private function retrieveRestResponseInfo(string $response) : RestResponse
    {
        $parts = explode("\r\n", $response);
        $this->response->setBody(end($parts))
        ->setHttpCode($this->retrieveCode($parts[0]))
        ->setTime($this->startTime, $this->endTime);

        return $this->response;
    }

    /**
     * @param string $header
     * @return mixed
     */
    private function retrieveCode(string $header)
    {
        $parts = explode(" ",$header);
        return $parts[1];
    }
}