<?php

class SocketCall extends HttpRequest
{
    /**
     * @var int
     * Default port
     */
    private $port = 80;

    /**
     * @var string
     * Host extracted from url.
     * Ex: http://house-net.ddns.net/secure/index.html
     * host =  http://house-net.ddns.net
     */
    private $host;

    /**
     * @var string
     * Path extracted from url.
     * Ex: http://house-net.ddns.net/secure/index.html
     * path = /secure/index.html
     */
    private $path;

    /**
     * @var bool
     * If set to true, send() method
     * will wait for server response.
     * If not, it will send the request
     * and continue without waiting for
     * response.
     */
    private $isWaitingForResponse = true;

    /**
     * @var null|RestResponse
     */
    private $restResponse = null;

    /**
     * Extracts http code from header.
     * @param string $header the header line
     * @return string http code
     * @throws Exception
     */
    private function retrieveCode(string $header) : string
    {
        if (!isset($header))
            throw new Exception("Wrong input in retrieve Code!");

        $parts = explode(" ", $header);

        if (count($parts) < 3)
            throw new Exception("Wrong header field!");

        return $parts[1];
    }

    /**
     * Makes Rest Response Object
     * @param $response string raw response form web-api
     * @return RestResponse packed object
     * @throws Exception
     */
    private function retrieveRestResponseInfo(string $response) : RestResponse
    {
        if (!isset($response))
            throw new Exception("Wrong input");

        $parts = explode("\r\n", $response);
        $this->restResponse->setBody(end($parts))
            ->setHttpCode($this->retrieveCode($parts[0]))
            ->setTime($this->startTime, $this->endTime);

        return $this->restResponse;
    }

    /**
     * @return string
     */
    private function makeInitialHeaderFields() : string
    {
        $headerFields = "{$this->method} " . $this->path . " HTTP/1.1\r\n";
        $headerFields .= "Host: ". $this->host . "\r\n";
        $headerFields .= "Content-Type: {$this->contentType}\r\n";
        $headerFields .= "Content-Length: " . strlen($this->jsonData)."\r\n";
        $headerFields .= "Connection: Close\r\n\r\n";
        $headerFields .= $this->jsonData;

        return $headerFields;
    }

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
        $this->restResponse = new RestResponse();
    }

    /**
     * Static constructor / factory
     */
    public static function create() : SocketCall
    {
        $instance = new self();
        return $instance;
    }

    /**
     * Sets URL.
     * @override
     * @param mixed $url
     * @throws Exception
     */
    public function setUrl(string $url)
    {
        if (!isset($url))
            throw new Exception("Bad input in setUrl!");

        $this->url = $url;
        $parts = parse_url($url);
        $this->host = $parts['host'];
        $this->path = $parts['path'];
    }

    /**
     * @param bool $isWaitingForResponse
     */
    public function isWaitingForResponse(bool $isWaitingForResponse)
    {
        $this->isWaitingForResponse = $isWaitingForResponse;
    }

    /**
     * Sends a request to server.
     * @return RestResponse
     * @throws Exception
     */
    public function send()
    {

        $this->startTime = $this->takeTime();

        $fp = fsockopen($this->host, $this->port, $errno, $errstr, 30);

        if (!$fp) throw new Exception("$errstr {$errno}\n");

        $headerFields = $this->makeInitialHeaderFields();

        fwrite($fp, $headerFields);

        if ($this->isWaitingForResponse)
        {
            $response = "";

            // Wait for the response
            // ans collect it.
            while (!feof($fp))
                $response .= fgets($fp, 4096);


            $this->endTime = $this->takeTime();

            fclose($fp);

            $res = $this->retrieveRestResponseInfo($response);

            return $res;
        }
        else {
            return;
        }


    }
}