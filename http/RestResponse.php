<?php

/**
 * RestRespond class
 * @property
 * @version     1.0.0
 * @category    class
 * @see http://php.net/manual/en/book.curl.php
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */
class RestResponse
{
    /**
     * Is the REST call
     * successful or not?
     *
     * @var bool
     */
    private $success = true;

    /**
     * The code that the server
     * sent.
     *
     * @var integer
     */
    private $http_code;

    /**
     * What was the content type of the response
     *
     * @var mixed
     */
    private $content_type;

    /**
     * Type of Error
     *
     * @var null
     */
    private $error = null;

    /**
     * The actual data
     *
     * @var mixed
     */
    private $body;

    /**
     *
     *
     * @var mixed
     */
    private $trace;

    /**
     * @var null
     */
    private $data = null;

    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $local_ip;

    /**
     * @var
     */
    private $local_port;

    /**
     * The IP address of the server
     * the message is being sent to
     *
     * @var
     */
    private $primary_ip;

    /**
     * The Port of the server
     * the message is being sent to
     *
     * @var
     */
    private $primary_port;

    /**
     * Properties of class
     *
     * @var mixed
     */
    private $prop = array();

    /**
     * The total time for
     * the request to reach
     * the server
     *
     * @var
     */
    private $total_time;

    /**
     * RestResponse constructor.
     *
     * @param $info
     * @param $method
     * @param $curl
     * @param $res
     * @throws Exception
     */
    public function __construct( $info, $method, $curl, $res ) {

        if ($info == null || $method == null || $curl == null || $res == null)
            throw new Exception("Null Info, can not construct RestResponse Object");

        //
        $this->url = $info['url'];
        $this->content_type = $info['content_type'];
        $this->http_code = $info['http_code'];
        $this->total_time = $info['total_time'];
        if ($this->http_code < 300) $this->success = true;
        $this->local_ip = $info['local_ip'];
        $this->local_port = $info['local_port'];
        $this->primary_ip = $info['primary_ip'];
        $this->primary_port = $info['primary_port'];
        $this->method = $method;
        $this->body = $res;

         // set properties in array
        $this->prop['url'] = $this->url;
        $this->prop['content_type'] = $this->content_type;
        $this->prop['http_code'] = $this->http_code;
        $this->prop['success'] = $this->success;
        $this->prop['local_ip'] = $this->local_ip;
        $this->prop['local_port'] = $this->local_port;
        $this->prop['primary_ip'] = $this->primary_ip;
        $this->prop['method'] = $this->method;
        $this->prop['body'] = $res;

      //  print_r($info);
    }

    /**
     * @return null
     */
    public function getError() {
        return $this->error;
    }

    /**
     * @return null
     */
    public function getSuccess() {
        return $this->success;
    }

    /**
     * @param null $error
     */
    public function setError( $error ) {
        $this->error = $error;
    }

    /**
     * @return null
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData( $data ) {
        $this->data = $data;
    } // converted object

    /**
     * @return boolean
     */
    public function isSuccess() {
        return $this->success;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess( $success ) {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getHttpCode() {
        return $this->http_code;
    }

    /**
     * @param mixed $http_code
     */
    public function setHttpCode( $http_code ) {
        $this->http_code = $http_code;
    }

    /**
     * @return mixed
     */
    public function getContentType() {
        return $this->content_type;
    }

    /**
     * @param mixed $content_type
     */
    public function setContentType( $content_type ) {
        $this->content_type = $content_type;
    }

    /**
     * @return mixed
     */
    public function getTotalTime() {
        return $this->total_time;
    }

    /**
     * @param mixed $total_time
     */
    public function setTotalTime( $total_time ) {
        $this->total_time = $total_time;
    }

    /**
     * @return mixed
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody( $body ) {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getTrace() {
        return $this->trace;
    }

    /**
     * @param mixed $trace
     */
    public function setTrace( $trace ) {
        $this->trace = $trace;
    }

    /**
     * toString magical method
     *
     * @return string
     */
    public function __toString()
    {
        $toString = "\n=========================================\n" .
            "SUCCESS : " .  $this->success . "\n" .
            "URL : " . $this->url . "\n" .
            "Content Type : " . $this->content_type . "\n" .
            "Method : " . $this->method . "\n" .
            "Total Time : " . $this->total_time . "\n" .
            "Local IP : " . $this->local_ip . "\n" .
            "Local Port : " .  $this->local_port . "\n" .
            "Primary IP : " . $this->primary_ip . "\n"  .
            "Primary Port : " . $this->primary_ip . "\n" .
            "------------------ BODY ------------------\n" .
            $this->body .
            "\n------------------- END ------------------\n\n";

        return $toString;
    }

    /**
     * Print Information about the
     * Rest Call
     */
    public function printInfo() {
        var_dump($this /*, (string)$this*/);
    }


}// end class




