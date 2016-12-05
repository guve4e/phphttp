<?php

/**
 * RestRespond class
 * @property  total_time
 * @version     1.0.0
 * @category    class
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */
class CallResponse
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
     * @return null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return null
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * @param null $error
     */
    public function setError( $error )
    {
        $this->error = $error;
    }

    /**
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param null $data
     */
    public function setData( $data )
    {
        $this->data = $data;
    } // converted object

    /**
     * @return boolean
     */
    public function isSuccess()
    {
        return $this->success;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess( $success )
    {
        $this->success = $success;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->http_code;
    }

    /**
     * @param mixed $http_code
     */
    public function setHttpCode( $http_code )
    {
        $this->http_code = $http_code;
    }

    /**
     * @return mixed
     */
    public function getContentType()
    {
        return $this->content_type;
    }

    /**
     * @param mixed $content_type
     */
    public function setContentType( $content_type )
    {
        $this->content_type = $content_type;
    }

    /**
     * @return mixed
     */
    public function getTotalTime()
    {
        return $this->total_time;
    }

    /**
     * @param mixed $total_time
     */
    public function setTotalTime( $total_time )
    {
        $this->total_time = $total_time;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody( $body )
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getTrace()
    {
        return $this->trace;
    }

    /**
     * @param mixed $trace
     */
    public function setTrace( $trace )
    {
        $this->trace = $trace;
    }


}// end class