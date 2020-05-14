<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__')
);

$suggestions = $client->suggestions->partyFindById('7704022980');

var_dump($suggestions);
