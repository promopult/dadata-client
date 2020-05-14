<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__')
);

$suggestions = $client->suggestions->bankSuggest('тиньк');

var_dump($suggestions);
