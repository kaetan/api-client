<?php

namespace Kaetan\ApiClient\Http;

use GuzzleHttp\Client;
use Kaetan\ApiClient\Exception\ApiException;
use Psr\Http\Message\ResponseInterface;

class HttpRequester implements RequesterInterface
{
    public function __construct(public Client $guzzleClient)
    {
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return ApiResponse
     * @throws ApiException
     */
    public function request(string $method, string $path, array $params = []): ApiResponse
    {
        try {
            $response = $this->guzzleClient->request($method, $path, $params);
        } catch (\Throwable $exception) {
            $message = $exception->getMessage();
            throw new ApiException("HTTP request failed: $message", $exception->getCode());
        }

        return $this->processResponse($response);
    }

    /**
     * @param ResponseInterface $response
     * @return ApiResponse
     * @throws ApiException
     */
    public function processResponse(ResponseInterface $response): ApiResponse
    {
        $body = json_decode($response->getBody(), true);
        $code = $response->getStatusCode();

        if ($body === null || $code < 200 || $code >= 300) {
            $message = "Invalid response from API: $body (HTTP response code $code)";
            throw new ApiException($message, $code);
        }

        return new ApiResponse($body, $code);
    }
}