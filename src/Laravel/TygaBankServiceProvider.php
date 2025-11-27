<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Laravel;

use Illuminate\Support\ServiceProvider;
use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\GuzzleHttpClient;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;
use TygaPay\TygaBank\Core\TygaBankClient;

final class TygaBankServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/tygabank.php', 'tygabank');

        $this->app->singleton(TygaBankConfig::class, function () {
            $cfg = config('tygabank');

            return new TygaBankConfig(
                api_key: (string) ($cfg['api_key'] ?? ''),
                api_secret: (string) ($cfg['api_secret'] ?? ''),
                base_urls: (array) ($cfg['base_urls'] ?? []),
                timeout: (float) ($cfg['timeout'] ?? 10.0),
                retries: (int) ($cfg['retries'] ?? 2),
                verify_signatures: (bool) ($cfg['verify_signatures'] ?? true),
            );
        });

        $this->app->bind(HttpClientInterface::class, fn () => new GuzzleHttpClient);

        $this->app->singleton(TygaBankClient::class, function ($app) {
            $config = $app->make(TygaBankConfig::class);
            $http = $app->make(HttpClientInterface::class);
            $signer = new HmacSigner($config->api_secret);
            $logger = $app['log'] ?? null;

            return new TygaBankClient($config, $http, $signer, $logger);
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/tygabank.php' => config_path('tygabank.php'),
        ], 'tygabank-config');
    }
}
