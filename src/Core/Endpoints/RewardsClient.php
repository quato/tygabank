<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class RewardsClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function payout(array $payload): array
    {
        $api_path = '/payout';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['rewards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function payoutBatch(array $payload): array
    {
        $api_path = '/payout/batch';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['rewards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function debit(array $payload): array
    {
        $api_path = '/debit';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['rewards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function debitRefund(array $payload): array
    {
        $api_path = '/debit/refund';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['rewards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
