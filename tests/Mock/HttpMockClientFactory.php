<?php

namespace App\Tests\Mock;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class HttpMockClientFactory
{
    private static array $responses = [];

    public static function create(): MockHttpClient
    {
        return new MockHttpClient(self::responseFactory(...));
    }

    public static function responseFactory(string $method, string $uri, array $options = []): MockResponse
    {
        if (!isset(self::$responses[$method][$uri])) {
            return new MockResponse('', ['http_code' => 404]);
        }

        $response = self::$responses[$method][$uri];

        if (\is_callable($response)) {
            $response = $response($options['body']);
        }

        if (\is_string($response)) {
            $response = new MockResponse($response);
        }

        return $response;
    }

    public static function addResponse(string $method, string $uri, string|callable|MockResponse $response): void
    {
        self::$responses[$method][$uri] = $response;
    }
}
