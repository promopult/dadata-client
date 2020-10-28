<?php

require __DIR__ . '/../vendor/autoload.php';

$client = new \Promopult\Dadata\Client(
    getenv('__TOKEN__'),
    getenv('__SECRET__'),
    new \GuzzleHttp\Client()
);

$suggestions = $client->suggestions->postalUnitGeolocate(
    '55.878', // lat
    '37.653', // lon
    100,      // count
    1000,     // radius
    [
        'is_closed' => false,                   // filter is_closed == false
        'address_kladr_id' => '7700000000000'   // filter by address_kladr_id
    ]
);

var_export($suggestions);
