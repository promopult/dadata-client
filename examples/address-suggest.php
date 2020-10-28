<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new \GuzzleHttp\Client()
);

$suggestions = $client->suggestions->addressSuggest('г Москва, ул Свободы, 50');

var_dump($suggestions);
