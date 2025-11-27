<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class CardsClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function createAccount(string $user_id, array $payload): array
    {
        $api_path = '/account/' . rawurlencode($user_id);
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function getAccount(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/account/' . rawurlencode($user_id) . '?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function kycStatus(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/account/' . rawurlencode($user_id) . '/kyc-status?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function orderCards(string $user_id, array $payload): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/order';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function orderSingle(string $user_id, array $payload): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/order-single';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function load(string $user_id, string $card_id, array $payload): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/load';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function lock(string $user_id, string $card_id): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/lock';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, []);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function unlock(string $user_id, string $card_id): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/unlock';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, []);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function sync(string $user_id): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/sync';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, []);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function activate(string $user_id, string $card_id, array $payload): array
    {
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/activate';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function credentials(string $user_id, string $card_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/credentials?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function loadStatus(string $user_id, string $card_id, string $tx_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/cards/' . rawurlencode($user_id) . '/' . rawurlencode($card_id) . '/load/' . rawurlencode($tx_id) . '?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function transactionLookup(string $user_id, string $tx_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/transactions/' . rawurlencode($user_id) . '/' . rawurlencode($tx_id) . '?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function fees(?int $timestamp_ms = null): array
    {
        $query = $timestamp_ms ? ('?timestamp=' . $timestamp_ms) : '';
        $api_path = '/fees' . $query;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function feesV2(?int $timestamp_ms = null): array
    {
        $query = $timestamp_ms ? ('?timestamp=' . $timestamp_ms) : '';
        $api_path = '/fees/v2' . $query;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function quoteOrder(string $user_id, array $query_params): array
    {
        $query = http_build_query($query_params);
        $api_path = '/cards/' . rawurlencode($user_id) . '/order/quote' . ($query ? ('?' . $query) : '');
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function quoteOrderSingle(string $user_id, array $query_params): array
    {
        $query = http_build_query($query_params);
        $api_path = '/cards/' . rawurlencode($user_id) . '/order-single/quote' . ($query ? ('?' . $query) : '');
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
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
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->post($url, $headers, []);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    public function health(): bool
    {
        $api_path = '/health';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['cards'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return $res->getStatusCode() >= 200 && $res->getStatusCode() < 300;
    }
}
