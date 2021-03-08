<?php

declare(strict_types=1);

namespace Promopult\Dadata;

/**
 * Class RequestFactory
 */
class RequestFactory implements \Promopult\Dadata\RequestFactoryInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $secret;

    public function __construct(
        string $token,
        string $secret
    ) {
        $this->token = $token;
        $this->secret = $secret;
    }

    /**
     * Creates request with necessary headers & encoded body.
     *
     * @param string $method
     * @param string $uri
     * @param array $args
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function createRequest(string $method, string $uri, array $args = []): \Psr\Http\Message\RequestInterface
    {
        return new \GuzzleHttp\Psr7\Request($method, $uri, [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Token ' . $this->token,
            'X-Secret' => $this->secret
        ], \json_encode($args));
    }
}
