<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\DTO\Users;

final class UserCreateRequest
{
    public function __construct(
        public readonly string $email,
        public readonly string $created_by,
        public readonly ?string $external_user_id = null,
        public readonly ?string $first_name = null,
        public readonly ?string $last_name = null,
        public readonly ?string $phone_number = null,
        public readonly ?string $date_of_birth = null,
        /** @var array{country?:string,city?:string,subdivision?:string,postalCode?:string}|null */
        public readonly ?array $customer_address = null,
        public readonly ?int $timestamp_ms = null,
    ) {}

    /** @return array<string,mixed> */
    public function toPayload(): array
    {
        $payload = [
            'email' => $this->email,
            'createdBy' => $this->created_by,
            'timestamp' => ($this->timestamp_ms ?? (int) (microtime(true) * 1000)),
        ];

        if ($this->external_user_id) {
            $payload['externalUserId'] = $this->external_user_id;
        }

        if ($this->first_name) {
            $payload['firstName'] = $this->first_name;
        }

        if ($this->last_name) {
            $payload['lastName'] = $this->last_name;
        }

        if ($this->phone_number) {
            $payload['phoneNumber'] = $this->phone_number;
        }

        if ($this->date_of_birth) {
            $payload['dateOfBirth'] = $this->date_of_birth;
        }

        if ($this->customer_address) {
            $payload['customerAddress'] = $this->customer_address;
        }

        return $payload;
    }
}
