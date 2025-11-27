<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Http;

use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

final class GuzzleHttpClient implements HttpClientInterface
{
    public function __construct(private readonly GuzzleClient $client = new GuzzleClient) {}

    /** @param array<string,string> $headers */
    public function get(string $url, array $headers = []): ResponseInterface
    {
        return $this->client->request('GET', $url, [
            'headers' => array_merge([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'tygabank-php-sdk',
            ], $headers),
        ]);
    }

    /** @param array<string,string> $headers @param array<string,mixed> $json */
    public function post(string $url, array $headers = [], array $json = []): ResponseInterface
    {
        return $this->client->request('POST', $url, [
            'headers' => array_merge([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'User-Agent' => 'tygabank-php-sdk',
            ], $headers),
            'json' => $json,
        ]);
    }
}
