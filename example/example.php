<?php

require_once("../phphttp/RestCall.php");

$request = null;

try {



    $restCall = new RestCall("Curl");
    $restCall->setUrl("http://localhost/web-api/index.php/mockcontroller/1001")
        ->setContentType("application/json")
        ->addBody(["aaa" => "dsdd"])
        ->setMethod("POST");

    $headers = [
        "ApiToken" => "some_token"
    ];

    $restCall->setHeaders($headers);
    $restCall->addHeader("SomeHeader", "SomeValue");

    // make the call
    $restCall->send();


    $str = $restCall->getResponseAsString();
    $json = $restCall->getResponseAsJson();
    
    var_dump($str);
    var_dump($json);


} catch (Exception $e) {
   
} finally {
 //  var_dump($str);
}

 
