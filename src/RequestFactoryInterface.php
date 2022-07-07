<?php

namespace Promopult\Dadata;

interface RequestFactoryInterface
{
    public function createRequest(
        string $method,
        string $uri,
        array $args = []
    ): \Psr\Http\Message\RequestInterface;
}
