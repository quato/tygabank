<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class UsersCryptoClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function createWallet(string $user_id, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/crypto/wallet';
        $payload = ['timestamp' => $timestamp_ms ?? (int) (microtime(true) * 1000)];
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function sync(string $user_id, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/crypto/sync';
        $payload = ['timestamp' => $timestamp_ms ?? (int) (microtime(true) * 1000)];
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function claimDepositAddress(string $user_id, string $network, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/crypto/claim-deposit-address';
        $payload = [
            'network' => $network,
            'timestamp' => $timestamp_ms ?? (int) (microtime(true) * 1000),
        ];
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function listDepositAddresses(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/user/' . rawurlencode($user_id) . '/crypto/deposit-addresses?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
