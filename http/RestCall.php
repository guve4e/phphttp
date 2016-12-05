<?php
require_once (CLASS_PATH . '/WebApiResponse.php');
require_once (CLASS_PATH . '/Logger.php');
require_once (CLASS_PATH . '/RestResponse.php');
/**
 * RestCall class
 * Makes a Call to the Web API
 * @version     1.0.0
 * @category    class
 * @license     GNU Public License <http://www.gnu.org/licenses/gpl-3.0.txt>
 */
class RestCall
{
    /**
     * @var bool
     */
    public $toDebug = false;

    /**
     * @var
     */
    private $apiHeaders;

    /**
     * @var
     */
    private $url_params;

    /**
     * @var string
     */
    private $user_token = "";

    /**
     * @var string
     */
    private $api_token = "Kjbd43n#1hvsoyjYHUIerJdS073%df3TS";

    /**
     * Mutator that sets the user_token variable
     * @param string
     */
    public function setUser($user) {
        if (!$user){
            $this->user_token = "";
        }
        else
        {
            $this->user_token = "";
        }

    }


    /**
     * Checks For Success
     * If Success error is null
     * If Not data is null
     * @param $response
     * @param $res
     * @return mixed
     */
    private function checkResponse($response, $res)
    {
        if ($response->getSuccess()) {
            $res->setData($response->getData());
        } else {
            $res->setError($response->getError());
        }
        return $res;
    }

    /**
     * Add parameters
     * @param $key
     * @param $value
     */
    public function addParameter($key, $value)
    {
        $this->url_params[$key] = $value;
    }

    /**
     * Add headers
     * @param $key
     * @param $value
     */
    public function addHeader($key, $value)
    {
        $this->apiHeaders[$key] = $value;
    }

    /**
     * Get URL
     * @param $url
     * @return RestCall
     */
    public function get_url($url): WebApiResponse
    {
        $res = new WebApiResponse();
        $response = $this->http_send("GET", "application/x-www-form-urlencoded", $url, "");
        // check response and return
        return $this->checkResponse($response,$res);
    }

    /**
     * Get JSON
     * Makes GET Request
     * @param $url
     * @return WebApiResponse
     */
    public function get_json($url): WebApiResponse
    {
        $res = new WebApiResponse();
        $response = $this->http_send("GET", "application/json", $url, "");
        // check response and return
        return $this->checkResponse($response,$res);
    }


    /**
     * Get JSON
     * Makes Post Request
     * @param $url
     * @param $mime
     * @param $data
     * @return RestCall
     */
    public function post_raw( $url, $mime, $data): WebApiResponse
    {
        $res = new WebApiResponse();
        $response = $this->http_send("POST", $mime, $url, $data);
        // check response and return
        return $this->checkResponse($response,$res);
    }

    /**
     * Get JSON
     * Makes Post Request
     * @param $url
     * @param $data
     * @return RestCall
     */
    public function post_url( $url, $data): WebApiResponse
    {
        $res = new WebApiResponse();
        $data_string = http_build_query($data);
        $response = $this->http_send("POST", "application/x-www-form-urlencoded", $url, $data_string);
        // check response and return
        return $this->checkResponse($response,$res);
    }

    /**
     * @param $url
     * @param $data
     * @return RestCall
     */
    public function post_json( $url, $data): WebApiResponse
    {
        global $config;
        $res = new WebApiResponse();
        $data_string = json_encode($data);
        $response = $this->http_send("POST", "application/json", $url, $data_string);

        $a = print_r($response,true);
        Logger::logVarDump("RESPONSE->" . $a);

        if ($config['debug']) // Log it
        {
            Logger::saveLogFile('post-'. date('Y-m-d-H-i-s') . ".json", json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
        // check response and return
        return $this->checkResponse($response,$res);
    }

    /**
     * Get JSON
     * Makes PUT Request
     * @param $url
     * @param $data
     * @return WebApiResponse
     */
    public function put_json( $url, $data): WebApiResponse
    {
        $res = new WebApiResponse();
        $data_string = json_encode($data);
        $response = $this->http_send("PUT", "application/json", $url, $data_string);
        // check response and return
        return $this->checkResponse($response,$res);
    }

    /**
     * Error Response
     * @param $result
     * @param $code
     * @param $msg
     * @return RestResponse
     */
    private function errorResponse( $result, $code, $msg): RestResponse {
        if (!isset($result)) {
            $result = new RestResponse();
        }
        $result->setSuccess(false);
        $result->setHttpCode($code);
        $result->setError($msg);
        return $result;
    }

    /**
     * Get Parameters String
     * @param string $prefix
     * @return string
     */
    private function getParamString( $prefix = "") {
        $result = "";
        foreach ($this->url_params as $key => $value) {
            if (!empty($result)) {
                $result .= "&";
            }
            $result .= $key . "=" . $value;
        }

        if (empty($result)) {
            return "";
        }
        return $prefix . $result;
    }

    /**
     * Displays an Error Page
     * @param $item
     * @param $reason
     * @param bool $toredirect
     */
    function error_page($item, $reason, $toredirect = false) {
        global $user;
        global $page_id;
        $dump = $reason . "\n";
        $dump .= "page_id: " . var_export($page_id, true). "\n";
        $dump .= "user: ". var_export($user, true). "\n";
        $dump .= "data: ". var_export($item, true). "\n";
        Logger::saveDumpFile("error500.json", $dump). "\n";
        if ($toredirect) {
            ob_end_clean();
            header("Location: error_500.php");
        } else {
            echo '<div id="page_content"><div id="page_content_inner">';
            print "<div class='uk-alert uk-alert-danger'>Error displaying this page: {$reason}</div>";
            print "<pre>\n";
            echo Logger::loadDumpFile("error500.json");
            print "</pre>\n";
            echo '</div></div>';
            //exit();
        }
    }

    /**
     * Create Response
     * Called From http_send()
     * @see http_send()
     * @param $method
     * @param $curl
     * @param $curl_response
     * @param $info
     * @return RestResponse
     */
    private function createResponse( $method, $curl, $curl_response, $info): RestResponse {
        $res = new RestResponse();
        $res->setHttpCode($info['http_code']);    // curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $res->setContentType($info['content_type']); // curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $res->setTotalTime($info['total_time']);
        $res->setBody($curl_response);

        if ($curl_response === false) {
            $res->setSuccess(false);
            $res->setTrace($method . " FAILED: " . var_export($info));
        }
        if (curl_errno($curl)) {
            $res->setSuccess(false);
            $res->setTrace($method. " ERROR: " . var_export($info));
        }
        // check success
        $success = $res->getSuccess();
        if ($success) {
            $code = $res->getHttpCode();
            if ($code < 300) {
                $pos = strpos($res->getContentType(), "json");

                if ($pos === false) {
                    $pos = strpos($res->getContentType(), "javascript");
                }
                if ($pos === false) {
                    return $res;
                } // not JSON output

                $res->setData(json_decode($res->getBody()));
                // get data
                $d = $res->getData();
                if (isset($d)){
                    return $res;
                }
                if ($this->toDebug) {
                    logDebug("Invalid JSON: " .$res->getBody());
                }
                return $this->errorResponse(null, 900, "Cannot parse JSON response");
            }
            // Process HTTP error
            Logger::logError("Invalid REST response: " . $res->getHttpCode());
            Logger::logDebug("Invalid REST response: " . $res->getHttpCode() . "\n" . $res->getBody());
            return $this->errorResponse($res, $res->getHttpCode(), $res->getBody());
        }

        return $res;
    }


    /**
     * HTTP_SEND
     * Uses Client URL Library libcurl
     *
     * @param string $method
     * @param $ctype
     * @param string $url
     * @param string $data_string
     * @return RestResponse
     */
    private function http_send(string $method, $ctype, string $url, string $data_string) {

        if ($this->toDebug) {
            $dpost = new \StdClass();
            $dpost->time = date("Y-m-d h:i:sa");
            $dpost->method = $method;
            $dpost->url = $url;
            if (!empty($data_string)) $dpost->data = $data_string;
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (!empty($method)){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        } 
        $headers = array();
        $headers[] = 'Content-Type: ' . $ctype;
        if (!empty($data_string)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
            $headers[] = 'Content-Length: ' . strlen($data_string);
        }
        foreach ($this->apiHeaders as $key => $value) {
            $headers[] = $key . ': ' . $value;
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        try {

            $curl_response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $res = $this->createResponse($method, $curl, $curl_response, $info);

            if ($this->toDebug) {
                Logger::logDebug($method . " " . $url);
                Logger::logDebug("  code: ". $res->getHttpCode());
                Logger::logDebug("  type: ". $res->getContentType());
                Logger::logDebug("  time: ". $res->getTotalTime());
                $dpost->response = $res;
            }

        } catch (Exception $e) {
            $res->setSuccess(false);
            $res->setTrace( $method . " EXCEPTION: " . var_export($e->getMessage()));
            if ($this->toDebug) {
                $dpost->error = " EXCEPTION: " . var_export($e->getMessage());
            }
        }
        curl_close($curl);
        if ($this->toDebug)  {
            Logger::logDebug($method . '-'. date('Y-m-d-H-i-s'));
            Logger::logDebug(json_encode($dpost, JSON_PRETTY_PRINT));
        }

        return $res;
    }
}