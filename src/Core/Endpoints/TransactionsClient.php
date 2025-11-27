<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\DTO\Transactions\PayoutRequest;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class TransactionsClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function createPayout(PayoutRequest $request): array
    {
        $api_path = '/payout';
        $payload = $request->toPayload();
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['transactions'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function confirm(string $payout_id, string $created_by): array
    {
        $api_path = '/payout/' . $payout_id . '/confirm';
        $payload = [
            'createdBy' => $created_by,
        ];
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['transactions'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function cancel(string $payout_id, string $cancelled_by): array
    {
        $api_path = '/payout/' . $payout_id . '/cancel';
        $payload = [
            'cancelledBy' => $cancelled_by,
            'timestamp' => (int) (microtime(true) * 1000),
        ];
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['transactions'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function payoutStatus(string $payout_id, int $timestamp_ms): array
    {
        $api_path = '/payout/' . $payout_id . '?timestamp=' . $timestamp_ms;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['transactions'], '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function listByUser(string $user_id, ?string $id = null, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/transactions/users?userId=' . rawurlencode($user_id) . ($id ? '&id=' . rawurlencode($id) : '') . '&timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['transactions'], '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
