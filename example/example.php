<?php

require_once("../http/RestCall.php");

try {
	// create instance 
    $r = RestCall::create();
    // set URL
    $r->setUrl("http://housenet.ddns.net/web-api/index.php/Test");
    // set Content Type
    $r->setContentType("application/json");
    // set Method
    $r->setMethod("POST ");

    // sample data 
    $json_data = [
        "name" => "John",
        "occupation" => "Programmer"
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
 
