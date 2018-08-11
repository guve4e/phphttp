<?php

use PHPUnit\Framework\TestCase;

require_once ("../phphttp/RestCall.php");
require_once ("../phphttp/File.php");

class RestCallCurlTest extends TestCase
{
    private $mockConnection;

    /**
     * Create test subject before test
     */
    protected function setUp()
    {
        $body = json_encode([ 'key' => 'value', 'title' => 'some_title' ]);
        $httpResponse = "HTTP/1.1 200 OK" . "\r\n" .
            "Date: Mon, 27 Jul 2009 12:28:53 GMT" . "\r\n" .
            "Server: Apache/2.2.14 (Win32)" . "\r\n" .
            "Last-Modified: Wed, 22 Jul 2009 19:15:56 GMT" . "\r\n" .
            "Content-Length: 88" . "\r\n" .
            "Content-Type: text/html" . "\r\n" .
            "Connection: Closed" . "\r\n\r\n" .
            $body;


        // Create a stub for the JsonLoader class
        $this->mockConnection = $this->getMockBuilder(File::class)
            ->setMethods(array('fileExists', 'close', 'getLine', 'endOfFile', 'socket', 'write'))
            ->getMock();

        $this->mockConnection->method('fileExists')
            ->willReturn(true);

        $this->mockConnection->method('getLine')
            ->will($this->onConsecutiveCalls($httpResponse, false)); // break the loop

        $this->mockConnection->expects($this->at(2))
            ->method('endOfFile')
            ->with(null)
            ->willReturn(false);

        $this->mockConnection->expects($this->at(4))
            ->method('endOfFile')
            ->with(null)
            ->willReturn(true);
    }

    /**
     * @throws Exception
     */
    public function testHttpSocketCall()
    {
        // Arrange
        $expectedString = json_encode([ 'key' => 'value', 'title' => 'some_title' ]);

        // Act
        $restCall = new RestCall("HttpSocket", $this->mockConnection);
        $restCall->setUrl("http://webapi.ddns.net/index.php/mockcontroller/1001");
        $restCall->setContentType("application/json");
        $restCall->setMethod("POST");
        $restCall->addBody(["a" => 'b']);
        $restCall->send();
        $responseAsJson = $restCall->getResponseAsJson();
        $responseAsString = $restCall->getResponseAsString();

        // Assert
        $this->assertEquals($expectedString, $responseAsString);
        $this->assertEquals([ 'key' => 'value', 'title' => 'some_title' ], $responseAsJson);
    }
}


