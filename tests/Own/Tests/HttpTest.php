<?php
namespace Own\Tests;

use \Own\Method as Http;

class HttpTest extends \PHPUnit_Framework_TestCase
{
    private $endpoint = 'http://headers.jsontest.com/';

    public function testOptionsGet()
    {
        $request = new Http\Post($this->endpoint, [
            'data' => [
                'name' => 'foo',
                'email' => 'foo@domain.com'
            ]
        ]);

        $options = $request->getCurlOptions();
        $this->assertTrue(strpos($options[10015], 'foo') !== false);
        $this->assertTrue(strpos($options[10015], 'domain.com') !== false);
        $this->assertEquals('POST', $options[10036]);

        $request->send();

        $options = $request->getCurlOptions();
        $this->assertTrue(strpos($options[10015], 'foo') !== false);
        $this->assertTrue(strpos($options[10015], 'domain.com') !== false);
        $this->assertEquals('POST', $options[10036]);
        $this->assertTrue($options[19913]);
        $this->assertTrue($options[2]);
    }

    public function testOptionsGetWithPayload()
    {
        $request = new Http\Post($this->endpoint, [
            'data' => [
                'name' => 'foo',
                'email' => 'foo@domain.com'
            ],
            'is_payload' => true,
            'headers' => [
                'Authorization: foobar'
            ]
        ]);

        $request->send();

        $options = $request->getCurlOptions();
        $this->assertEquals('POST', $options[10036]);
        $this->assertEquals(1, $options[47]);
        $this->assertEquals('{"name":"foo","email":"foo@domain.com"}', $options[10015]);
        $this->assertEquals('Authorization: foobar', $options[10023][0]);
        $this->assertEquals('Content-Type: application/json', $options[10023][1]);
        $this->assertEquals('Content-Length: 39', $options[10023][2]);
    }

    public function testOptionsSet()
    {
        $request = new Http\Get($this->endpoint);
        $options = $request->getCurlOptions();

        $this->assertNull($options[27]);

        $request->setCurlOption(CURLOPT_CRLF, true);
        $options = $request->getCurlOptions();

        $this->assertTrue($options[27]);
    }

    public function testCurlInfoGet()
    {
        $request = new Http\Get($this->endpoint, [
            'autoclose' => false
        ]);

        $request->send();

        $code = $request->getCurlInfo(CURLINFO_HTTP_CODE);

        $request->close();

        $this->assertEquals(200, $code);
    }
}
