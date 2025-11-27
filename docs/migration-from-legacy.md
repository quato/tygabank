# Migration from Legacy

Map old classes to SDK calls:

- `App\Services\Payments\TygaPayApiClient::signApiRequest` → `HmacSigner::sign($apiPath, $payload)`
- `App\Services\Payments\TygaPayService::createOrder` → `TygaBankClient->orders()->create(OrderCreateRequest)`
- `App\Services\Payments\TygaPayService::getPaymentStatus` → `TygaBankClient->orders()->get($id)`
- `App\Services\Payments\TygaPayService::handleIPN` → use `WebhookVerifier` or middleware
- `App\Services\Users\TygaPayUserService` methods → `users()` equivalents
