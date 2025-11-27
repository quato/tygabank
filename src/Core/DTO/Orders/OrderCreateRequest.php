<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\DTO\Orders;

final class OrderCreateRequest
{
    public function __construct(
        public readonly string $type,
        public readonly string $order_number,
        public readonly float $amount,
        public readonly string $webhook_url,
        public readonly string $return_url,
        public readonly string $customer_email,
        public readonly ?int $timestamp_ms = null,
    ) {}

    /**
     * @return array<string,mixed>
     */
    public function toPayload(): array
    {
        return [
            'type' => $this->type,
            'orderNumber' => $this->order_number,
            'webhookUrl' => $this->webhook_url,
            'returnUrl' => $this->return_url,
            'customerInformation' => [
                'email' => $this->customer_email,
            ],
            'amount' => $this->amount,
            'timestamp' => ($this->timestamp_ms ?? (int) (microtime(true) * 1000)),
        ];
    }
}
