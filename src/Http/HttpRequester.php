<?php

namespace Kaetan\ApiClient\Http;

use GuzzleHttp\Exception\GuzzleException;
use Kaetan\ApiClient\Exception\ApiException;

class HttpRequester
{
    /**
     * @var string $baseUrl
     */
    private static string $baseUri = 'https://example.com';

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return ApiResponse
     * @throws ApiException
     * @throws GuzzleException
     */
    public function request(string $method, string $path, array $params = []): ApiResponse
    {
        $guzzle = new \GuzzleHttp\Client(['base_uri' => self::$baseUri]);

        try {
            $response = $guzzle->request($method, $path, $params);
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            throw new ApiException("Invalid response from API: $message", $exception->getCode());
        }

        $body = json_decode($response->getBody(), true);
        $code = $response->getStatusCode();

        if ($body === null || $code < 200 || $code >= 300) {
            $message = "Invalid response from API: $body (HTTP response code $code)";
            throw new ApiException($message, $code);
        }

        return new ApiResponse($body, $code);
    }
}