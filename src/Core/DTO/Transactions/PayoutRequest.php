<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\DTO\Transactions;

final class PayoutRequest
{
    public function __construct(
        public readonly string $user_id,
        public readonly float $amount,
        public readonly string $external_transaction_id,
        public readonly string $created_by,
        public readonly string $email,
        public readonly ?string $currency = null,
        public readonly ?bool $process_immediately = null,
        public readonly ?string $webhook_url = null,
        public readonly ?int $timestamp_ms = null,
    ) {}

    /** @return array<string,mixed> */
    public function toPayload(): array
    {
        $payload = [
            'userId' => $this->user_id,
            'amount' => $this->amount,
            'externalTransactionId' => $this->external_transaction_id,
            'createdBy' => $this->created_by,
            'timestamp' => ($this->timestamp_ms ?? (int) (microtime(true) * 1000)),
            'email' => $this->email,
        ];

        if ($this->currency) {
            $payload['currency'] = $this->currency;
        }

        if ($this->process_immediately !== null) {
            $payload['processImmediately'] = $this->process_immediately;
        }

        if ($this->webhook_url) {
            $payload['webhookUrl'] = $this->webhook_url;
        }

        return $payload;
    }
}
