<?php

declare(strict_types=1);

namespace Promopult\Dadata;

interface CredentialsInterface
{
    public function getToken(): string;
    public function getSecret(): string;
}
