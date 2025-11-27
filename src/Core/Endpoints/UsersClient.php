<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Endpoints;

use TygaPay\TygaBank\Core\Auth\HmacSigner;
use TygaPay\TygaBank\Core\Config\TygaBankConfig;
use TygaPay\TygaBank\Core\DTO\Users\UserCreateRequest;
use TygaPay\TygaBank\Core\Http\HttpClientInterface;

final class UsersClient
{
    public function __construct(
        private readonly TygaBankConfig $config,
        private readonly HttpClientInterface $http,
        private readonly HmacSigner $signer,
    ) {}

    /** @return array<string,mixed> */
    public function completeRegistration(string $user_id, array $payload = [], ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/complete-registration';
        $payload['timestamp'] = $payload['timestamp'] ?? ($timestamp_ms ?? (int) (microtime(true) * 1000));
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function sendVerifyEmail(string $user_id, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/send-verify-email';
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
    public function confirmVerifyEmail(string $user_id, array $payload, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/confirm-verify-email';
        $payload['timestamp'] = $payload['timestamp'] ?? ($timestamp_ms ?? (int) (microtime(true) * 1000));
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function kycSession(string $user_id, array $payload = []): array
    {
        $api_path = '/user/' . rawurlencode($user_id) . '/kyc/session';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function batch(array $users_payload): array
    {
        $api_path = '/user/batch';
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $users_payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $users_payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function linkUser(string $email, string $external_user_id, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/link';
        $payload = [
            'email' => $email,
            'externalUserId' => $external_user_id,
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
    public function unlinkUser(string $email, string $external_user_id, ?int $timestamp_ms = null): array
    {
        $api_path = '/user/unlink';
        $payload = [
            'email' => $email,
            'externalUserId' => $external_user_id,
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
    public function wallet(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/user/' . rawurlencode($user_id) . '/wallet?timestamp=' . $ts;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function create(UserCreateRequest $request): array
    {
        $api_path = '/user';
        $payload = $request->toPayload();
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, $payload),
        ];
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $res = $this->http->post($url, $headers, $payload);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function getById(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/user/' . $user_id . '?timestamp=' . $ts;
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function getByEmail(string $email, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/user?timestamp=' . $ts . '&email=' . rawurlencode($email);
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }

    /** @return array<string,mixed> */
    public function emailExists(string $email, string $external_user_id): array
    {
        $api_path = '/user/exists';
        $payload = [
            'email' => $email,
            'externalUserId' => $external_user_id,
            'timestamp' => (int) (microtime(true) * 1000),
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
    public function balances(string $user_id, ?int $timestamp_ms = null): array
    {
        $ts = $timestamp_ms ?? (int) (microtime(true) * 1000);
        $api_path = '/user/' . rawurlencode($user_id) . '/wallet?timestamp=' . $ts;
        $url = rtrim($this->config->base_urls['users'], '/') . $api_path;
        $headers = [
            'x-api-key' => $this->config->api_key,
            'x-api-hash' => $this->signer->sign($api_path, []),
        ];
        $res = $this->http->get($url, $headers);

        return json_decode((string) $res->getBody(), true) ?? [];
    }
}
