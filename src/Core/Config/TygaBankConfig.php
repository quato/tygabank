<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Config;

final class TygaBankConfig
{
    public function __construct(
        public readonly string $api_key,
        public readonly string $api_secret,
        /** @var array{auth:string,users:string,orders:string,payments?:string,transactions:string} */
        public readonly array $base_urls,
        public readonly float $timeout = 10.0,
        public readonly int $retries = 2,
        public readonly bool $verify_signatures = true,
    ) {}
}
