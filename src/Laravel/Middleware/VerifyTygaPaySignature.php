<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Laravel\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use TygaPay\TygaBank\Core\Webhooks\WebhookVerifier;

final class VerifyTygaPaySignature
{
    public function __construct(private readonly WebhookVerifier $verifier) {}

    public function handle(Request $request, Closure $next, string $apiPath = '/payment/ipn/tygapay'): Response
    {
        $signature = $request->headers->get('x-api-hash');

        if (!$this->verifier->verify($signature, $apiPath, $request->all())) {
            return response()->noContent(400);
        }

        return $next($request);
    }
}
