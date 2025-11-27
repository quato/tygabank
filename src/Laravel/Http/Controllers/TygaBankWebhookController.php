<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Laravel\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TygaPay\TygaBank\Core\Webhooks\WebhookVerifier;

final class TygaBankWebhookController extends Controller
{
    public function __invoke(Request $request, WebhookVerifier $verifier, ResponseFactory $response)
    {
        $api_path = '/payment/ipn/tygapay';
        $sig = $request->headers->get('x-api-hash');

        if (!$verifier->verify($sig, $api_path, $request->all())) {
            return $response->noContent(400);
        }

        return $response->noContent();
    }
}
