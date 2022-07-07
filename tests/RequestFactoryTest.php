<?php

namespace Pomopult\Dadata\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Promopult\Dadata\Credentials;
use Promopult\Dadata\Service;

class RequestFactoryTest extends TestCase
{
    private $factory;

    public function setUp(): void
    {
        $credentials = $this->createMock(Credentials::class);
        $credentials->method('getSecret')->willReturn('secret1234');
        $credentials->method('getToken')->willReturn('token1234');

        $httpClient = $this->createMock(Client::class);

        $this->factory = new class($credentials, $httpClient)  extends Service {};
    }

    public function testRequestFactoryMustCreateRequestInterface()
    {
        $request = $this->factory->createRequest('POST', 'https://example.com');

        $this->assertInstanceOf(\Psr\Http\Message\RequestInterface::class, $request);
    }

    public function testRequestHeadersMustContainsCredentials()
    {
        $req = $this->factory->createRequest('POST', 'https://example.com');

        $this->assertEquals(['secret1234'], $req->getHeader('X-Secret'));
        $this->assertEquals(['Token token1234'], $req->getHeader('Authorization'));
    }

    public function testRequestHeadersMustContainsAcceptAndContentTypeHeaders()
    {
        $req = $this->factory->createRequest('POST', 'https://example.com');

        $this->assertEquals(['application/json'], $req->getHeader('Accept'));
        $this->assertEquals(['application/json'], $req->getHeader('Content-Type'));
    }

    public function testRequestMustContainsJsonBodyWithCorrectData()
    {
        $req = $this->factory->createRequest('POST', 'https://example.com', ['query' => 'test']);

        $this->assertJsonStringEqualsJsonFile(__DIR__.'/resources/body.json', $req->getBody()->getContents());
    }
}
