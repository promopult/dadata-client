<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new Http\Adapter\Guzzle6\Client()
);

$clean = $client->clean->address('сходненс');

var_dump($clean);
