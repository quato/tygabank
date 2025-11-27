<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class ReportingClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function tenantTransactions(string $start_date, string $end_date, string $type, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/transactions/tenant?timestamp=' . $ts . '&startDate=' . rawurlencode($start_date) . '&endDate=' . rawurlencode($end_date) . '&type=' . rawurlencode($type);
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['reporting'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function usersTransactions(string $start_date, string $end_date, string $type, string $wallet_type, array $user_ids, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $query = 'timestamp=' . $ts . '&startDate=' . rawurlencode($start_date) . '&endDate=' . rawurlencode($end_date) . '&type=' . rawurlencode($type) . '&walletType=' . rawurlencode($wallet_type);

        foreach ($user_ids as $id) {
            $query .= '&userIds=' . rawurlencode((string) $id);
        }
        $api_path = '/transactions/users?' . $query;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['reporting'] ?? '', '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
