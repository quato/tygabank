<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\DTO\Orders;

final class OrderResponse
{
    public function __construct(
        public readonly string $order_id,
        public readonly ?string $status = null,
        public readonly ?string $payment_url = null,
        /** @var array<string,mixed> */
        public readonly array $raw = [],
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            order_id: (string) ($data['orderId'] ?? $data['id'] ?? ''),
            status: isset($data['status']) ? (string) $data['status'] : null,
            payment_url: isset($data['paymentUrl']) ? (string) $data['paymentUrl'] : null,
            raw: $data,
        );
    }
}
