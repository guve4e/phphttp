<?php

require_once("../phphttp/RestCall.php");

$request = null;

try {


    $restCall = new RestCall("Socket");
    $restCall->setUrl("http://localhost/web-api/index.php/mockcontroller/1001")
        ->setContentType("application/json")
        ->setMethod("GET")
        ->isWaitingForResponse(false);

    $headers = [
        "ApiToken" => "some_token"
    ];

    $restCall->setHeaders($headers);

    // make the call
    $request = $restCall->send();

} catch (Exception $e) {
   
} finally {
   var_dump($request);
}

 
