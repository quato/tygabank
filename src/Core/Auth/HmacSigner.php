<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Auth;

use TygaPay\TygaBank\Core\Support\QueryStringBuilder;

final class HmacSigner
{
    public function __construct(private readonly string $api_secret) {}

    /**
     * Sign request using api path + flattened body/query per TygaPay rules.
     *
     * @param  array<string,mixed>  $payload
     */
    public function sign(string $api_path, array $payload = []): string
    {
        $body_query = $payload ? QueryStringBuilder::build($payload) : '';
        $string_to_sign = $api_path . $body_query;

        return hash_hmac('sha256', $string_to_sign, $this->api_secret);
    }
}
