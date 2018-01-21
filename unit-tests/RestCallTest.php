<?php

use PHPUnit\Framework\TestCase;
require_once("../http/RestCall.php");
require_once ("UtilityTest.php");

class RestCallTest extends TestCase
{
    use UtilityTest;

    /**
     * @var
     */
    protected $rest;

    /**
     * Create test subject before test
     */
    protected function setUp()
    {
        // create instance
        $this->rest = RestCall::create();
    }

    /**
     *
     */
    public function testSetUrl()
    {
        // Arrange
        $this->rest->setUrl("http://example.com/test/index.php");

        $url = $this->getProperty($this->rest, "url");

        $this->assertEquals($url, "http://example.com/test/index.php");
    }

    /**
     * @expectedException Exception
     */
    public function testSetUrlTypeThrowsException()
    {
        // Arrange
        $this->rest->setUrl(null);
    }

    /**
     * Test Proper setting of content type
     */
    public function testSetContentType()
    {
        // Arrange
        $this->rest->setContentType("application/json");

        // Act
        $contentType1 = "application/json";

        $contentType2 = $this->getProperty($this->rest, "content_type");

        // Assert
        $this->assertEquals($contentType1, $contentType2);
    }

    /**
     * @expectedException Exception
     */
    public function testSetContentTypeThrowsException()
    {
        // Arrange
        $this->rest->setContentType(null);
    }

    /**
     * Test Proper setting of content type
     */
    public function testSetMethod()
    {
        // Arrange
        $this->rest->setMethod("POST");

        // Act
        $method = $this->getProperty($this->rest, "method");

        // Assert
        $this->assertEquals($method, "POST");
    }

    /**
     * @expectedException Exception
     */
    public function testSetMethodThrowsException()
    {
        // Arrange
        $this->rest->setMethod(null);
    }

    /**
     *
     */
    public function testSetJsonData()
    {
        // Arrange
        $json_data1 = [
            "key" => "value",
            "num" => 123
        ];

        // Act
        $this->rest->setJsonData($json_data1);
        $json_data2 = $this->getProperty($this->rest, "json_data");

        //Assert
        $this->assertEquals(json_encode($json_data1), $json_data2);
    }

    /**
     * @expectedException Exception
     */
    public function testSetJsonDataThrowsException()
    {
        // Arrange
        $this->rest->setJsonData(null);
    }

    /**
     *
     */
    public function testMakeheaders()
    {

        // make headers
        $headers = [
            "a" => "b",
            "c" => "d"
        ];

        // set headers
        $this->rest->setHeaders($headers);

        $headers1 = $this->getProperty($this->rest, "headers");

        $headers2 = [
            0 => "a: b",
            1 => "c: d"
        ];

        // Assert
        $this->assertEquals($headers1, $headers2);
    }

    /**
     * @expectedException Exception
     */
    public function testMakeheadersThrowsException()
    {
        // Arrange
        $this->rest->setHeaders(null);
    }

    /**
     *
     */
    public function onNotSuccessfulTest(Throwable $t)
    {
        parent::onNotSuccessfulTest($t); // TODO: Change the autogenerated stub
    }
}


