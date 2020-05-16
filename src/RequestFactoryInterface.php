<?php

declare(strict_types=1);

namespace Promopult\Dadata;

/**
 * Interface RequestFactoryInterface
 */
interface RequestFactoryInterface
{
    public function createRequest(string $method, string $uri, array $args = []): \Psr\Http\Message\RequestInterface;
}
