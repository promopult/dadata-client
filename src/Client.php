<?php

declare(strict_types=1);

namespace Promopult\Dadata;

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
    /**
     * @var \Psr\Http\Client\ClientInterface
     */
    private $httpClient;

    /**
     * @var \Promopult\Dadata\RequestFactoryInterface
     */
    private $requestFactory;

    /**
     * Client constructor.
     *
     * @param mixed ...$args Ожидает на вход строки Токена и Секрета или фабрику запросов уже
     *                       инициализированную Токеном и Секретом, а так же PSR-18-совместимый HTTP-клиент.
     *
     *                       Например,
     *                          $client = new Client('token', 'secret', new \Guzzlehttp\Client);
     *                          $client = new Client(new RequestFactory('token', 'secret'), new \Guzzlehttp\Client);
     */
    public function __construct(...$args)
    {
        $credentials = [];

        foreach ($args as $arg) {
            if ($arg instanceof \Promopult\Dadata\RequestFactoryInterface) {
                $this->requestFactory = $arg;
            }

            if ($arg instanceof \Psr\Http\Client\ClientInterface) {
                $this->httpClient = $arg;
            }

            if (is_string($arg)) {
                $credentials[] = $arg;
            }
        }

        if (empty($this->httpClient)) {
            throw new \Promopult\Dadata\Exceptions\InvalidConfigurationException(
                "Http client is not initialized."
            );
        }

        if (empty($this->requestFactory)) {
            if (!is_string($credentials[0]) || !is_string($credentials[1])) {
                throw new \Promopult\Dadata\Exceptions\InvalidConfigurationException(
                    "Invalid credentials. Expect Token and Secret variables in order."
                );
            }

            [$token, $secret] = $credentials;

            $this->requestFactory = new \Promopult\Dadata\RequestFactory($token, $secret);
        }
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
            $this->requestFactory,
            $this->httpClient
        );
    }

    public function __get($name): Service
    {
        return $this->getService($name);
    }
}
