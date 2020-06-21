<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new Http\Adapter\Guzzle6\Client()
);

$suggestions = $client->suggestions->addressSuggest('г Москва, ул Свободы, 50с3');

var_dump($suggestions);
