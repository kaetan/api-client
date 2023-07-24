<?php

namespace Kaetan\ApiClient\Http;

interface RequesterInterface
{
    public function request(string $method, string $path, array $params = []): ApiResponse;
}