<?php

declare(strict_types=1);

namespace Promopult\Dadata;

/**
 * Interface ServiceFactoryInterface
 *
 * @author Dmitry Gladyshev <gladyshevd@icloud.com>
 */
interface ServiceFactoryInterface
{
    public function getService(string $serviceName): Service;
}
