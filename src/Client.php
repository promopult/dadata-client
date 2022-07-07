<?php

namespace Promopult\Dadata;

use Psr\Http\Client\ClientInterface;

/**
 * Class Client
 *
 * Services
 * @property \Promopult\Dadata\Services\Suggestions $suggestions
 * @property \Promopult\Dadata\Services\Clean $clean
 * @property \Promopult\Dadata\Services\Profile $profile
 */
class Client implements ServiceFactoryInterface
{
    private RequestFactoryInterface $requestFactory;
    private ClientInterface $httpClient;
    private CredentialsInterface $credentials;

    public function __construct(
        CredentialsInterface $credentials,
        ClientInterface $httpClient
    ) {
        $this->credentials = $credentials;
        $this->httpClient = $httpClient;
    }

    public function getService(string $serviceName): Service
    {
        $serviceClass = __NAMESPACE__ . '\\Services\\' . ucfirst($serviceName);

        if (!class_exists($serviceClass)) {
            throw new \Promopult\Dadata\Exceptions\ServiceNotFoundException(
                "Service with {$serviceName} is not found."
            );
        }

        return new $serviceClass(
            $this->credentials,
            $this->httpClient
        );
    }

    public function __get($name): Service
    {
        return $this->getService($name);
    }
}
