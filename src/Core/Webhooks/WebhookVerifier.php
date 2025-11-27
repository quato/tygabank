<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Webhooks;

use TygaPay\TygaBank\Core\Auth\HmacSigner;

final class WebhookVerifier
{
    public function __construct(private readonly HmacSigner $signer) {}

    /**
     * @param  array<string,mixed>  $payload
     */
    public function verify(?string $signature, string $api_path, array $payload): bool
    {
        if ($signature === null || $signature === '') {
            return false;
        }
        $computed = $this->signer->sign($api_path, $payload);

        return hash_equals($computed, $signature);
    }
}
