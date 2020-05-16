<?php

declare(strict_types=1);

namespace Promopult\Dadata;

/**
 * Interface ServiceFactoryInterface
 */
interface ServiceFactoryInterface
{
    public function getService(string $serviceName): Service;
}
