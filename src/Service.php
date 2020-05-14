<?php

declare(strict_types=1);

namespace Promopult\Dadata;

/**
 * Class Service
 */
abstract class Service
{
    /**
     * @var \Promopult\Dadata\RequestFactory
     */
    protected $requestFactory;

    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    protected $httpClient;

    /**
     * AbstractService constructor.
     * @param RequestFactory $requestFactory
     * @param \Psr\Http\Client\ClientInterface $httpClient
     */
    public function __construct(
        \Promopult\Dadata\RequestFactory $requestFactory,
        \Psr\Http\Client\ClientInterface $httpClient
    ) {
        $this->requestFactory = $requestFactory;
        $this->httpClient = $httpClient;
    }
}
