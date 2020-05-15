<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new Http\Adapter\Guzzle6\Client()
);

$suggestions = $client->suggestions->partyFindById('7733768188');

var_export($suggestions);
