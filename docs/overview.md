# Overview

TygaBank SDK provides a typed PHP interface to TygaPay/TygaBank APIs with Laravel 12 integration.

- Auth: `x-api-key` and HMAC `x-api-hash` derived from `apiPath + flattened body/query`.
- Endpoints: Users, Orders, Transactions (Payouts).
- Webhooks: Verify signature via provided `WebhookVerifier` or middleware.
