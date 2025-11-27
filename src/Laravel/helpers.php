<?php

declare(strict_types=1);

use TygaPay\TygaBank\Core\TygaBankClient;

if (!function_exists('tygabank')) {
    function tygabank(): TygaBankClient
    {
        /** @var TygaBankClient $client */
        $client = app(TygaBankClient::class);

        return $client;
    }
}
