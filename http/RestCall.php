<?php
require_once ("RestResposne.php");
/**
 * RestCall class
 * Wrapper to libcurl
 * @see <http://php.net/manual/en/book.curl.php>
 * @version     1.0.0
 * @category    class
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */
class RestCall
{
    /**
     * @var
     */
    private $method;

    /**
     * @var
     */
    private $content_type;

    /**
     * @var
     */
    private $headers = array();

    /**
     * @var
     */
    private $url;

    /**
     * @var
     */
    private $json_data;

    /**
     * @var
     */
    private $data_send;
    
    /**
     * @var
     */
    private $debug = true;
    
    /**
     * RestCall constructor.
     */
    function __construct() {

    }// end constructor

    /**
     * Static constructor / factory
     */
    public static function create() {

        $instance = new self();
        return $instance;
    }// end

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
        if ($method == "GET") $this->data_send = false;
        else $this->data_send = true;
    }// end

    /**
     * @param mixed $content_type
     */
    public function setContentType($content_type)
    {
        $this->content_type = $content_type;
        $this->headers [] = 'Content-Type: ' . $content_type;

    }// end

    /**
     * @param mixed $headers
     */
    public function setHeaders($headers)
    {
        $this->make_headers($headers);
    }// end

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }// end

    /**
     * @param mixed $json_data
     */
    public function setJsonData($json_data)
    {
        $this->json_data = $json_data;
    }// end

    /**
     *
     * @param $debug
     * @throws Exception
     */
    public function setDebug($debug)
    {
        if ($debug == true) $this->debug = $debug;
        else if ($debug == false) $this->debug = $debug;
        else throw new Exception("Debug Value must be boolean!");
    }

    /**
     * Send Request
     */
    public function sendRequest() {
        return $this->http_send();
    }

    /**
     * Sets the Headers
     */
    private function make_headers($headers) {

        foreach ($headers as $key => $value) {
            $this->headers[] = $key . ': ' . $value;
        }
    }// end

    /**
     *
     * @return null
     * @throws Exception
     */
    private function http_send() {

        if ($this->method == null) throw new Exception("Null Method");
        if ($this->content_type == null) throw new Exception("Null Content Type");

        // initialize
        $curl = curl_init($this->url);

        // TRUE to return the transfer as a string
        // of the return value of curl_exec()
        // instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // A custom request method to use instead of "GET" or
        // "HEAD" when doing a HTTP request. This is useful
        // for doing "DELETE" or other, more obscure HTTP requests.
        // Valid values are things like "GET", "POST", "CONNECT" and so on;
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $this->method);

        // set headers
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);

        // The full data to post in a HTTP "POST" operation. To post a file,
        // prepend a filename with @ and use the full path. The filetype can be
        // explicitly specified by following the filename with the type in the
        // format ';type=mimetype'. This parameter can either be passed as a
        // urlencoded string like 'para1=val1&para2=val2&...' or as an array with
        // the field name as key and field data as value. If value is an array, the
        // Content-Type header will be set to multipart/form-data. As of PHP 5.2.0,
        // value must be an array if files are passed to this option with the @ prefix.
        // As of PHP 5.5.0, the @ prefix is deprecated and files can be sent using CURLFile.
        // The @ prefix can be disabled for safe passing of values beginning with @ by
        // setting the CURLOPT_SAFE_UPLOAD option to TRUE.
        if ($this->data_send) {
            if ($this->json_data == null) throw new Exception("Specify Data to Send");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->json_data);
        }


        $res = null;
        try {
            $res = curl_exec($curl);
            $info = curl_getinfo($curl);

            $log = new RestResponse($info,$this->method, $curl, $res);
            if ($this->debug) $log->printInfo();

        } catch (Exception $e) {

        } finally {
            curl_close($curl);
            return json_decode($res);
        }
    }// end
}// end class


try {

    $r = RestCall::create();
    $r->setUrl("http://carstuff.ddns.net/web-api/index.php/Test");
    $r->setContentType("application/json");
    $r->setMethod("POST");
    $json_data = [
        "name" => "John",
        "occupation" => "Programmer"
    ];

    $r->setJsonData($json_data);

    $headers = [
        "a" => "b",
        "c" => "d"
    ];

    $r->setHeaders($headers);

    $s = $r->sendRequest();
    print_r($s);
} catch (Exception $e) {
    echo $e->getMessage();
}



