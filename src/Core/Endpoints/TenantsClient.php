<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class TenantsClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function wallets(): array
    {
        $api_path = '/api-tenants/wallets';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['tenants'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function usersTotalBalances(): array
    {
        $api_path = '/api-tenants/users/total-balances';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['tenants'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
