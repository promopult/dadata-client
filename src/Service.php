<?php

namespace Promopult\Dadata;

use Psr\Http\Client\ClientInterface;

abstract class Service implements RequestFactoryInterface
{
    protected ClientInterface $httpClient;
    protected CredentialsInterface $credentials;

    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
        $this->credentials = $credentials;
    }

    /**
     * Creates request with necessary headers & encoded body.
     */
    public function createRequest(
        string $method,
        string $uri,
        array $args = []
    ): \Psr\Http\Message\RequestInterface {
        return new \GuzzleHttp\Psr7\Request($method, $uri, [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . $this->credentials->getToken(),
            'X-Secret' => $this->credentials->getSecret()
        ], \json_encode($args));
    }
}
