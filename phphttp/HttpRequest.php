<?php
require_once("HttpRequestInterface.php");
/**
 * HttpRequest class
 *
 * @version     2.0.0
 * @category    class
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */

abstract class HttpRequest implements HttpRequestInterface
{
    /**
     * @var string
     * represent URL
     */
    protected $url;

    /**
     * @var string
     * HTTP Method
     * (GET, POST, etc)
     */
    protected $method;

    /**
     * @var
     * MIME type
     */
    protected $contentType;

    /**
     * @var
     * Request fields
     */
    protected $headers;

    /**
     * @var mixed
     * Data to be sent
     */
    protected $jsonData;
    
    /**
     * @var
     */
    protected $debug = true;

    /**
     * @var int
     * Start Time
     * Time taken before the call.
     */
    protected $startTime;

    /**
     * @var int
     * Start Time
     * Time taken after the call.
     */
    protected $endTime;

    /**
     * Take time in microsecond
     * @return float
     */
    protected function takeTime() : float
    {
        return microtime(true);
    }

    /**
     * Sets Method.
     * @precondition Valid Method Name
     * @param mixed $method
     * @throws Exception
     */
    public function setMethod(string $method)
    {
    	// preconditions
        if ($method == null) throw new Exception("Null Method");

        $this->method = $method;
        if ($method == "GET") $this->data_send = false;
        else $this->data_send = true;
    }

    /**
     * Sets the content type.
     * @precondition Valid Content Type
     * @param mixed $contentType
     * @throws Exception
     */
    public function setContentType(string $contentType)
    {
    	  // preconditions
        if ($contentType == null) throw new Exception("Null ContentType");

        $this->contentType = $contentType;
        $this->headers [] = 'Content-Type: ' . $contentType;
    }

    /**
     * Sets headers.
     * @param mixed $headers
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->headers[] = $key . ': ' . $value;
        }
    }

    /**
     * Sets URL.
     * @param mixed $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * Encodes data in json format.
     * @param mixed $jsonData
     * @throws Exception
     */
    public function setJsonData($jsonData)
    {
        // preconditions
        if ($jsonData == null) throw new Exception("Null Json Data");
        
          $this->jsonData = json_encode($jsonData);
    }

    /**
     * Debug.
     * @param $debug
     * @throws Exception
     */
    public function setDebug(bool $debug)
    {
        if ($debug == true) $this->debug = $debug;
        else if ($debug == false) $this->debug = $debug;
        else throw new Exception("Debug Value must be boolean!");
    }

    abstract public function send();
}

