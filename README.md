# TygaBank PHP SDK (Laravel 12 Ready)

Framework-agnostic PHP SDK and Laravel integration for TygaBank (TygaPay) APIs.

- Package: `tygapay/tygabank`
- Namespace: `TygaPay\TygaBank`
- PHP: ^8.3

## Installation

```bash
composer require tygapay/tygabank
```

## Configuration (Laravel)

Publish config:

```bash
php artisan vendor:publish --tag=tygabank-config
```

Set environment variables in `.env`:

```env
TYGABANK_API_KEY=your_key
TYGABANK_API_SECRET=your_secret
TYGABANK_APP_URL=https://app.tygabank.com

# Optional: Override base URLs
TYGABANK_BASE_URL_AUTH=https://api-auth-it7ww2bo7q-uc.a.run.app
TYGABANK_BASE_URL_USERS=https://api-users-it7ww2bo7q-uc.a.run.app
TYGABANK_BASE_URL_ORDERS=https://api-orders-it7ww2bo7q-uc.a.run.app
TYGABANK_BASE_URL_TRANSACTIONS=https://api-transactions-it7ww2bo7q-uc.a.run.app
```

## Usage

### Create Payment Order

```php
use TygaPay\TygaBank\Core\DTO\Orders\OrderCreateRequest;

$order_request = new OrderCreateRequest(
    type: 'payment',
    order_number: '123',
    amount: 9.99,
    webhook_url: 'https://example.com/ipn',
    return_url: 'https://example.com/ok',
    customer_email: 'user@example.com',
);

$result = tygabank()->orders()->create($order_request);
```

### Create User

```php
use TygaPay\TygaBank\Core\DTO\Users\UserCreateRequest;

$user_request = new UserCreateRequest(
    email: 'user@example.com',
    created_by: 'system',
    external_user_id: '123',
    first_name: 'John',
    last_name: 'Doe',
    phone_number: '+1234567890',
    date_of_birth: '1990-01-01',
    customer_address: ['country' => 'US']
);

$result = tygabank()->users()->create($user_request);
```

### Get User Balances

```php
$balances = tygabank()->users()->balances('userId');
```

### Create Payout

```php
use TygaPay\TygaBank\Core\DTO\Transactions\PayoutRequest;

$payout_request = new PayoutRequest(
    user_id: 'tygabank-user-id',
    amount: 50.00,
    external_transaction_id: 'ext_123',
    created_by: 'system',
    email: 'user@example.com',
    currency: 'USD',
    webhook_url: 'https://example.com/webhook'
);

$result = tygabank()->transactions()->createPayout($payout_request);
```

### Generate SSO Token

```php
$sso = tygabank()->auth()->clientToken(
    timestamp_ms: null,
    user_id: 'tygabank-user-id',
    external_user_id: '123'
);

// Redirect to: $sso['loginUrl']
```

## Available Endpoints

```php
// Auth
$token = tygabank()->auth()->clientToken();

// Users
$user = tygabank()->users()->getByEmail('user@example.com');
$user = tygabank()->users()->getById('userId');
$balances = tygabank()->users()->balances('userId');

// Transactions
$payout = tygabank()->transactions()->createPayout($request);
$status = tygabank()->transactions()->payoutStatus('payoutId', time() * 1000);
$transactions = tygabank()->transactions()->listByUser('userId');

// Orders
$order = tygabank()->orders()->create($request);

// Reporting
$tenant = tygabank()->reporting()->tenantTransactions(
    '2025-03-01', 
    '2025-04-01', 
    'commission_payout', 
    time() * 1000
);
```

## Webhooks

The SDK includes webhook signature verification:

```php
use TygaPay\TygaBank\Core\Webhooks\WebhookVerifier;

$verifier = app(WebhookVerifier::class);
$is_valid = $verifier->verify(
    $signature,
    $api_path,
    $payload
);
```

## License

MIT
