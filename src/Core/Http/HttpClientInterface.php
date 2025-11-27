<?php

declare(strict_types=1);

namespace TygaPay\TygaBank\Core\Http;

use Psr\Http\Message\ResponseInterface;

interface HttpClientInterface
{
    /**
     * @param  array<string,string>  $headers
     */
    public function get(string $url, array $headers = []): ResponseInterface;

    /**
     * @param  array<string,string>  $headers
     * @param  array<string,mixed>  $json
     */
    public function post(string $url, array $headers = [], array $json = []): ResponseInterface;
}
