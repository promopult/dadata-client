<?php

namespace Pomopult\Dadata\Tests;

use Promopult\Dadata\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    private $client;

    public function setUp(): void
    {
        $this->client = new Client(
            new \Promopult\Dadata\Credentials('token', 'secret'),
            new \GuzzleHttp\Client()
        );
    }

    /**
     * @param string $name
     *
     * @dataProvider validServiceNamesDataProvider
     */
    public function testCreatesService($name)
    {
        $service = $this->client->getService($name);

        $this->assertInstanceOf(\Promopult\Dadata\Service::class, $service);
    }

    /**
     * @param string $name
     *
     * @dataProvider invalidServiceNamesDataProvider
     */
    public function testThrowsServiceNotFoundExceptionOnInvalidServiceName($name)
    {
        $this->expectException(\Promopult\Dadata\Exceptions\ServiceNotFoundException::class);

        $this->client->getService($name);
    }

    public function validServiceNamesDataProvider()
    {
        return [
            ['clean'],
            ['suggestions'],
            ['profile']
        ];
    }

    public function invalidServiceNamesDataProvider()
    {
        return [
            ['fuckyouservice'],
        ];
    }
}
