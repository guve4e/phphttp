<?php

require_once("../phphttp/RestCall.php");
require_once("../phphttp/FileManager.php");

$request = null;

try {

    // api wit curl
    $restCall = new RestCall("Curl", new FileManager());
    $restCall->setUrl("localhost/web-api/index.php/mockcontroller/1001")
        ->setContentType("application/json")
        ->addBody(["aaa" => "dsdd"])
        ->setMethod("POST");
    
    // give it array as headers 
    $restCall->setHeaders( [ "ApiToken" => "some_token"]);
    // or you add to the headers as key value pair
    $restCall->addHeader("SomeHeader", "SomeValue");

    // make the call
    $restCall->send();
    
    // get the response as string
    $str = $restCall->getResponseAsString();
    // or get the response as JSON
    $json = $restCall->getResponseAsJson();
    
    
    var_dump($str);
    var_dump($json);
    
    // api with socket
     // api
    $restCall = new RestCall("HttpSocket", new FileManager());
    $restCall->setUrl("http://localhost/web-api/index.php/mockcontroller/1001")
        ->setContentType("application/json")
        ->addBody(["aaa" => "dsdd"])
        ->setMethod("POST");
    
    // give it array as headers 
    $restCall->setHeaders( [ "ApiToken" => "some_token"]);
    // or you add to the headers as key value pair
    $restCall->addHeader("SomeHeader", "SomeValue");
    
    // make the call
    $restCall->send();
    
    // get the response as string
    $str = $restCall->getResponseAsString();
    // or get the response as JSON
    $json = $restCall->getResponseAsJson();
    // or get the whole raw response
    $raw = $restCall->getResponseRaw();
    
    var_dump($str);
    var_dump($json);
    var_dump($raw);

} catch (Exception $e) {
   print "Exception :" . $e;
} finally {

}

 
