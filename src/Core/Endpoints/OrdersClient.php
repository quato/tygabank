<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\DTO\Orders\OrderCreateRequest;
use TygaPay\TygaBank\Core\DTO\Orders\OrderResponse;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class OrdersClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    public function create(OrderCreateRequest $request): OrderResponse
    {
        $api_path = '/';
        $payload = $request->toPayload();
        $sig = $this->signer->sign($api_path, $payload);
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $sig,
        ];
        $url = rtrim($this->config->base_urls['orders'], '/') . $api_path;
        $response = $this->http->post($url, $headers, $payload);
        $data = json_decode((string) $response->getBody(), true) ?? [];

        return OrderResponse::fromArray($data);
    }

    public function get(string $order_id, ?int $timestamp_ms = null): OrderResponse
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/orders/' . $order_id . '?timestamp=' . $ts;
        $sig = $this->signer->sign($api_path, []);
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $sig,
        ];
        $url = rtrim($this->config->base_urls['orders'], '/') . $api_path;
        $response = $this->http->get($url, $headers);
        $data = json_decode((string) $response->getBody(), true) ?? [];

        return OrderResponse::fromArray($data);
    }
}
