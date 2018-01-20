<?php

/**
 * Simple Data Class.
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
     */
    public function setHttpCode( $http_code ) {
        $this->http_code = $http_code;
        return $this;
    }

    /**
     * @param $startTime
     * @param $endTime
     * @return RestResponse
     */
    public function setTime($startTime, $endTime ) {
        $this->timeSpent = $endTime - $startTime;
        return $this;
    }

    /**
     * @return RestResponse
     */
    public function setBody(string $body) {
        $this->body = $body;
        return $this;
    }

    /**
     * @return null
     */
    public function isSuccessful() {
        return $this->http_code < 300;
    }

    /**
     * @return null
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getTotalTime() : string
    {
        $timeFormat = sprintf('%02d', $this->timeSpent);
        return $timeFormat;
    }
}
