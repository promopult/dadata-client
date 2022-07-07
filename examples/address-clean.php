<?php

use Promopult\Dadata\Credentials;

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    new Credentials(getenv('__TOKEN__'), getenv('__SECRET__')),
    new \GuzzleHttp\Client()
);

$clean = $client->clean->address('сходненс');

var_dump($clean);
