<?php
/**
 * Created by PhpStorm.
 * User: home
 * Date: 1/20/18
 * Time: 11:05 AM
 */

require_once ("HttpRequest.php");
require_once ("RestResponse.php");

class CurlCall extends HttpRequest
{

    /**
     * RestCall constructor.
     */
    function __construct() {
        // check if php_curl is installed
        if (!function_exists('curl_version'))
            throw new Exception("PHP Curl not installed");
    }

    /**
     * Static constructor / factory
     */
    public static function create() : CurlCall
    {
        $instance = new self();
        return $instance;
    }

    /**
     * Makes HTTP Call to specified URL
     *
     * @return string json string / Curl Response
     * @throws Exception
     */
    public function send() : RestResponse
    {
        // preconditions
        if ($this->method == null) throw new Exception("Null Method");
        if ($this->contentType == null) throw new Exception("Null Content Type");
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
        // prepend a filename with @ and use the full path. The file-type can be
        // explicitly specified by following the filename with the type in the
        // format ';type=mimetype'. This parameter can either be passed as a
        // urlencoded string like 'para1=val1&para2=val2&...' or as an array with
        // the field name as key and field data as value. If value is an array, the
        // Content-Type header will be set to multipart/form-data. As of PHP 5.2.0,
        // value must be an array if files are passed to this option with the @ prefix.
        // As of PHP 5.5.0, the @ prefix is deprecated and files can be sent using CURLFile.
        // The @ prefix can be disabled for safe passing of values beginning with @ by
        // setting the CURLOPT_SAFE_UPLOAD option to TRUE.
        if ($this->jsonData)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->jsonData);

        $restResponse = null;
        try {
            $this->startTime = $this->takeTime();
            $response = curl_exec($curl);
            $this->endTime = $this->takeTime();

            $info = curl_getinfo($curl);

            // TODO log info here
            $resError =  json_last_error();

            if($resError != 0)
                throw new Exception("Exception in curl!");

            $restResponse = $this->retrieveRestResponseInfo($response, $info);

        } catch (Exception $e) {

            $a = $e;

           // Logger::logMsg("JSON_API_EXCEPTION {$resError}", $e->getMessage());
        } finally {
            curl_close($curl);

            // curl_exec has success property
            return $restResponse;
        }
    }

    private function retrieveRestResponseInfo($response, $info) : RestResponse
    {
        $res = new RestResponse();
        $res->setHttpCode($info['http_code'])
            ->setTime($this->startTime, $this->endTime)
            ->setBody($response);
        return $res;
    }
}