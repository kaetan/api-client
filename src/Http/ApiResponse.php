<?php

namespace Kaetan\ApiClient\Http;

class ApiResponse
{
    /**
     * @param array $body
     * @param int $code
     */
    public function __construct(protected array $body, protected int $code)
    {
    }

    /**
     * @return array
     */
    public function getBody(): array
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