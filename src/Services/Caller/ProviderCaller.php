<?php

namespace App\Services\Caller;

use App\Services\Interfaces\ProviderCallerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ProviderCaller implements ProviderCallerInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function call(string $url): ResponseInterface
    {
        return $this->httpClient->request('GET', $url);
    }
}
