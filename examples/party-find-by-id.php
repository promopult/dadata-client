<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    new \Promopult\Dadata\Credentials(getenv('__TOKEN__'), getenv('__SECRET__')),
    new \GuzzleHttp\Client()
);

$suggestions = $client->suggestions->partyFindById(
    '4884a73832fa80ee246b5bb6147abb6e52ee1291a3cff398d548167392b25d84' // Это hid из ответа метода partySuggest()
);

var_export($suggestions);
