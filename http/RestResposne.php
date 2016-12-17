<?php

/**
 * RestRespond class
 * @property
 * @version     1.0.0
 * @category    class
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */
class RestResponse
{
    /**
     * @var bool
     */
    private $success = true;

    /**
     * @var integer
     */
    private $http_code;

    /**
     * @var mixed
     */
    private $content_type;

    /**
     * @var null
     */
    private $error = null;

    /**
     * @var mixed
     */
    private $body;

    /**
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
     * @var
     */
    private $primary_ip;

    /**
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
     * RestResponse constructor
     */
    public function __construct($info, $method, $curl, $res) {
        if ($info == null) throw new Exception("Null Info");

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
     * Print Information about the
     * Rest Call
     */
    public function printInfo() {
        echo "=========================================\n";
        echo "SUCCESS : " .  $this->success . "\n";
        echo "URL : " . $this->url . "\n";
        echo "Content Type : " . $this->content_type . "\n";
        echo "Method : " . $this->method . "\n";
        echo "Total Time : " . $this->total_time . "\n";
        echo "Local IP : " . $this->local_ip . "\n";
        echo "Local Port : " .  $this->local_port . "\n";
        echo "Primary IP : " . $this->primary_ip . "\n";
        echo "Primary Port : " . $this->primary_ip . "\n";
        echo "------------------ BODY ------------------\n";
        print_r($this->body);
        echo "\n------------------- END ------------------\n";
    }


}// end class




