<?php

declare(strict_types=1);

return [
    'api_key' => env('TYGABANK_API_KEY', env('TYGAPAY_API_KEY')),
    'api_secret' => env('TYGABANK_API_SECRET', env('TYGAPAY_API_SECRET')),

    'base_urls' => [
        'auth' => env('TYGABANK_BASE_URL_AUTH', env('TYGAPAY_BASE_URL_AUTH', 'https://api-auth-it7ww2bo7q-uc.a.run.app')),
        'users' => env('TYGABANK_BASE_URL_USERS', env('TYGAPAY_BASE_URL_USERS', 'https://api-users-it7ww2bo7q-uc.a.run.app')),
        'orders' => env('TYGABANK_BASE_URL_ORDERS', env('TYGAPAY_BASE_URL_ORDERS', 'https://api-orders-it7ww2bo7q-uc.a.run.app')),
        'payments' => env('TYGABANK_BASE_URL_PAYMENTS', env('TYGAPAY_BASE_URL_PAYMENTS', 'https://api-payments-it7ww2bo7q-uc.a.run.app')),
        'transactions' => env('TYGABANK_BASE_URL_TRANSACTIONS', env('TYGAPAY_BASE_URL_TRANSACTIONS', 'https://api-transactions-it7ww2bo7q-uc.a.run.app')),
        'reporting' => env('TYGABANK_BASE_URL_REPORTING', env('TYGAPAY_BASE_URL_REPORTING')),
        'cards' => env('TYGABANK_BASE_URL_CARDS', env('TYGAPAY_BASE_URL_CARDS')),
        'crypto' => env('TYGABANK_BASE_URL_CRYPTO', env('TYGAPAY_BASE_URL_CRYPTO')),
        'tenants' => env('TYGABANK_BASE_URL_TENANTS', env('TYGAPAY_BASE_URL_TENANTS')),
        'rewards' => env('TYGABANK_BASE_URL_REWARDS', env('TYGAPAY_BASE_URL_REWARDS')),
    ],

    'timeout' => 10.0,
    'retries' => 2,
    'verify_signatures' => true,
];
