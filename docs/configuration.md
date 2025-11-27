# Configuration

Publish config and set env vars:

```bash
php artisan vendor:publish --tag=tygabank-config
```

`.env` keys:

- `TYGABANK_API_KEY`
- `TYGABANK_API_SECRET`
- `TYGABANK_BASE_URL_AUTH`
- `TYGABANK_BASE_URL_USERS`
- `TYGABANK_BASE_URL_ORDERS`
- `TYGABANK_BASE_URL_PAYMENTS`
- `TYGABANK_BASE_URL_TRANSACTIONS`

Behavior:
- `timeout` (float), `retries` (int), `verify_signatures` (bool)
