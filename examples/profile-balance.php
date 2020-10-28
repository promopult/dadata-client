<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new \GuzzleHttp\Client()
);

$balance = $client->profile->balance();

var_dump($balance);
