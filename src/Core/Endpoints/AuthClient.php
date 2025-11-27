<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class AuthClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function clientToken(?int $timestamp_ms = null, ?string $user_id = null, ?string $external_user_id = null): array
    {
        $api_path = '/client-token';
        $payload = ['timestamp' => $timestamp_ms ?? (int) (microtime(true) * 1000)];

        if ($user_id !== null && $user_id !== '') {
            $payload['userId'] = $user_id;
        }

        if ($external_user_id !== null && $external_user_id !== '') {
            $payload['externalUserId'] = $external_user_id;
        }
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['auth'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
