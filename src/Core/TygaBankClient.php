<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core;

use Psr\Log\LoggerInterface;
use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Endpoints\AuthClient;
use TygaPay\TygaBank\Core\Endpoints\CardsClient;
use TygaPay\TygaBank\Core\Endpoints\CryptoCoreClient;
use TygaPay\TygaBank\Core\Endpoints\EwalletClient;
use TygaPay\TygaBank\Core\Endpoints\OrdersClient;
use TygaPay\TygaBank\Core\Endpoints\OrdersRefundsClient;
use TygaPay\TygaBank\Core\Endpoints\OrdersSubscriptionsClient;
use TygaPay\TygaBank\Core\Endpoints\ReportingClient;
use TygaPay\TygaBank\Core\Endpoints\RewardsClient;
use TygaPay\TygaBank\Core\Endpoints\TenantsClient;
use TygaPay\TygaBank\Core\Endpoints\TransactionsClient;
use TygaPay\TygaBank\Core\Endpoints\UsersClient;
use TygaPay\TygaBank\Core\Endpoints\UsersCryptoClient;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class TygaBankClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
        private readonly ?LoggerInterface $logger = null,
    ) {}

    public function config(): TygaBankConfig
    {
        return $this->config;
    }

    public function signer(): HmacSigner
    {
        return $this->signer;
    }

    public function orders(): OrdersClient
    {
        return new OrdersClient($this->config, $this->http, $this->signer);
    }

    public function users(): UsersClient
    {
        return new UsersClient($this->config, $this->http, $this->signer);
    }

    public function transactions(): TransactionsClient
    {
        return new TransactionsClient($this->config, $this->http, $this->signer);
    }

    public function auth(): AuthClient
    {
        return new AuthClient($this->config, $this->http, $this->signer);
    }

    public function reporting(): ReportingClient
    {
        return new ReportingClient($this->config, $this->http, $this->signer);
    }

    public function ordersRefunds(): OrdersRefundsClient
    {
        return new OrdersRefundsClient($this->config, $this->http, $this->signer);
    }

    public function subscriptions(): OrdersSubscriptionsClient
    {
        return new OrdersSubscriptionsClient($this->config, $this->http, $this->signer);
    }

    public function usersCrypto(): UsersCryptoClient
    {
        return new UsersCryptoClient($this->config, $this->http, $this->signer);
    }

    public function rewards(): RewardsClient
    {
        return new RewardsClient($this->config, $this->http, $this->signer);
    }

    public function ewallet(): EwalletClient
    {
        return new EwalletClient($this->config, $this->http, $this->signer);
    }

    public function cards(): CardsClient
    {
        return new CardsClient($this->config, $this->http, $this->signer);
    }

    public function crypto(): CryptoCoreClient
    {
        return new CryptoCoreClient($this->config, $this->http, $this->signer);
    }

    public function tenants(): TenantsClient
    {
        return new TenantsClient($this->config, $this->http, $this->signer);
    }
}
