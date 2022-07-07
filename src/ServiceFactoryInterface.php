<?php

namespace Promopult\Dadata;

interface ServiceFactoryInterface
{
    public function getService(string $serviceName): Service;
}
