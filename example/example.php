<?php

require_once("../http/RestCall.php");

try {
	// create instance 
    $r = RestCall::create();
    // set URL
    $r->setUrl("http://crypto.com/crystalpure/web-api/index.php/braintree");
    // set Content Type
    $r->setContentType("application/json");
    // set Method
    $r->setMethod("POST");

    // sample data 
    $json_data = [
        "nonce" => "nonce",
        "amount" => 123
    ];

    // set to JSON format
    $r->setJsonData($json_data);

    // make headers
    $headers = [
        "a" => "b",
        "c" => "d"
    ];

    // set headers
    $r->setHeaders($headers);

    // send the request
    $s = $r->sendRequest();
    // print the result
    print_r($s);
    
} 	catch (Exception $e) {
    echo $e->getMessage();
}

?>
 
