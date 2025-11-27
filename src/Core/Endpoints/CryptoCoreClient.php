<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class CryptoCoreClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    public function health(): bool
    {
        $api_path = '/health';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['crypto'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return $res->getStatusCode() >= 200 && $res->getStatusCode() < 300;
    }

    /** @return array<string,mixed> */
    public function swapEstimateExternal(array $payload): array
    {
        $api_path = '/swaps/external/estimate';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['crypto'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function swapCreateExternal(array $payload): array
    {
        $api_path = '/swaps/external';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['crypto'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function swapGetExternal(string $user_id, string $transaction_id, int $timestamp_ms): array
    {
        $api_path = '/swaps/external/' . rawurlencode($user_id) . '/' . rawurlencode($transaction_id) . '?timestamp=' . $timestamp_ms;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['crypto'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function otpSend(string $user_id): array
    {
        $api_path = '/otp/' . rawurlencode($user_id) . '/send';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['crypto'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, []);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
