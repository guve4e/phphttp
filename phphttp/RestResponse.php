<?php

/**
 * Simple Data Class
 * to represent a Rest Response.
 */
class RestResponse
{
    /**
     * The code that the server
     * sent.
     *
     * @var integer
     */
    private $http_code;

    /**
     * The actual data
     *
     * @var mixed
     */
    private $body;

    /**
     * The total time taken
     * to complete the request
     * @var
     */
    private $timeSpent;

    /**
     * RestResponse constructor.
     */
    public function __construct() {

    }

    /**
     * @param mixed $http_code
     * @return RestResponse
     * @throws Exception
     */
    public function setHttpCode(string $http_code) : RestResponse
    {
        if (!isset($http_code))
            throw new Exception("Null Code!");

        $this->http_code = $http_code;
        return $this;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return RestResponse
     * @throws Exception
     */
    public function setTime(float $startTime, float $endTime ) : RestResponse
    {
        if (!isset($startTime) || !isset($endTime))
            throw new Exception("Null Time!");

        $this->timeSpent = $endTime - $startTime;
        return $this;
    }

    /**
     * @return RestResponse
     * @throws Exception
     */
    public function setBody(string $body) : RestResponse
    {
        if (!isset($body))
            throw new Exception("Null Body!");

        $this->body = $body;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSuccessful() : bool
    {
        return $this->http_code < 300;
    }

    /**
     * @return string
     * Raw string.
     * Note, not json_encoded
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return mixed
     * Info about the call.
     */
    public function getInfo() : array
    {
        return [
            "code" => $this->http_code,
            "time" => $this->timeSpent,
            "success" => $this->isSuccessful()
        ];
    }
}
