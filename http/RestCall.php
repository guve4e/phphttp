<?php
require_once("RestResponse.php");
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
     * setMethod
     *
     * @precondition Valid Method Name
     * @param mixed $method
     * @throws Exception
     */
    public function setMethod($method)
    {
        // preconditions
        if ($method == null) throw new Exception("Null Method");

        $this->method = $method;
        if ($method == "GET") $this->data_send = false;
        else $this->data_send = true;
    }// end

    /**
     * setContentType
     *
     * @precondition Valid Content Type
     * @param mixed $content_type
     * @throws Exception
     */
    public function setContentType($content_type)
    {
        // preconditions
        if ($content_type == null) throw new Exception("Null ContentType");

        $this->content_type = $content_type;
        $this->headers [] = 'Content-Type: ' . $content_type;

    }// end

    /**
     * setHeaders
     *
     * @param mixed $headers
     * @throws Exception if null parameter supplied
     */
    public function setHeaders($headers)
    {
        // preconditions
        if ($headers == null) throw new Exception("Null Headers");
        $this->makeHeaders($headers);
    }// end

    /**
     * setUrl
     *
     * @param mixed $url
     * @throws Exception
     */
    public function setUrl($url)
    {
        // preconditions
        if ($url == null) throw new Exception("Null URL");
        $this->url = $url;
    }// end

    /**
     * setJsonData
     *
     * @param mixed $json_data
     * @throws Exception
     */
    public function setJsonData($json_data)
    {
        // preconditions
        if ($json_data == null) throw new Exception("Null Json Data");

        $this->json_data = json_encode($json_data);
    }// end


    /**
     * sendRequest
     *
     */
    public function sendRequest() {
        return $this->http_send();
    }

    /**
     * makeHeaders
     *
     * Sets the Headers
     */
    private function makeHeaders($headers) {

        foreach ($headers as $key => $value) {
            $this->headers[] = $key . ': ' . $value;
        }
    }// end

    /**
     * Makes HTTP Call to specified URL
     *
     * @return string json string / Curl Response
     * @throws Exception
     */
    private function http_send() {

        // preconditions
        if ($this->method == null) throw new Exception("Null Method");
        if ($this->content_type == null) throw new Exception("Null Content Type");
        if ($this->url == null) throw new Exception("Null Url");

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

        // set more options for curl info response
        curl_setopt($curl, CURLINFO_PRIVATE, true); // show private data
        curl_setopt($curl, CURLINFO_HEADER_OUT, true); // show request heder
        curl_setopt($curl, CURLINFO_RTSP_SESSION_ID, true);// show the RTSP session ID
        curl_setopt($curl, CURLINFO_COOKIELIST, true); // show all known cookies

        $res = null;
        try {
            $res = curl_exec($curl);
            $info = curl_getinfo($curl);

            $log = new RestResponse($info,$this->method, $curl, $res);
           // $log->printInfo();

        } catch (Exception $e) {

        } finally {
            curl_close($curl);
            return json_decode($res);
        }
    }// end
}// end class




