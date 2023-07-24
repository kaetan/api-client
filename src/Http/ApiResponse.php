<?php

namespace Kaetan\ApiClient\Http;

class ApiResponse
{
    /**
     * @param array|string $body
     * @param int $code
     */
    public function __construct(protected array|string $body, protected int $code)
    {
    }

    /**
     * @return array|string
     */
    public function getBody(): array|string
    {
        return $this->body;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

}