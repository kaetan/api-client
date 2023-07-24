<?php

namespace Kaetan\ApiClient\Service;

use Kaetan\ApiClient\Entity\AbstractEntity;
use Kaetan\ApiClient\Entity\BasicIdEntity;
use Kaetan\ApiClient\Exception\ApiException;
use Kaetan\ApiClient\Http\ApiResponse;
use Kaetan\ApiClient\Http\RequesterInterface;

abstract class AbstractService
{
    public function __construct(protected RequesterInterface $httpRequester)
    {
    }

    abstract protected function getEntityClass(): string;

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return AbstractEntity[]
     * @throws ApiException
     */
    protected function requestList(string $method, string $path, array $params = []): array
    {
        $response = $this->httpRequester->request($method, $path, $params);
        $class = $this->getEntityClass();
        $this->checkBody($response);

        return array_map(function ($itemData) use ($class) {
            return new $class($itemData);
        }, $response->getBody());
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return AbstractEntity
     * @throws ApiException
     */
    protected function requestItem(string $method, string $path, array $params = []): AbstractEntity
    {
        $response = $this->httpRequester->request($method, $path, $params);
        $class = $this->getEntityClass();
        $this->checkBody($response);

        return new $class($response->getBody());
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return BasicIdEntity
     * @throws ApiException
     */
    protected function requestId(string $method, string $path, array $params = []): BasicIdEntity
    {
        $response = $this->httpRequester->request($method, $path, $params);
        $this->checkBody($response);

        return new BasicIdEntity($response->getBody());
    }

    /**
     * @param ApiResponse $response
     * @return void
     * @throws ApiException
     */
    protected function checkBody(ApiResponse $response)
    {
        $body = $response->getBody();

        if (!is_array($body)) {
            throw new ApiException('Failed to process response - incorrect body.');
        }
    }
}