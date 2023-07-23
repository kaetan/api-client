<?php

namespace Kaetan\ApiClient\Service;

use GuzzleHttp\Exception\GuzzleException;
use Kaetan\ApiClient\Entities\AbstractEntity;
use Kaetan\ApiClient\Entities\BasicIdEntity;
use Kaetan\ApiClient\Exception\ApiException;
use Kaetan\ApiClient\Http\HttpRequester;

abstract class AbstractService
{
    public function __construct(protected HttpRequester $httpRequester)
    {
    }

    abstract protected function getEntityClass(): string;

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return AbstractEntity[]
     * @throws GuzzleException
     * @throws ApiException
     */
    protected function requestList(string $method, string $path, array $params = []): array
    {
        $response = $this->httpRequester->request($method, $path, $params);
        $class = $this->getEntityClass();

        return array_map(function ($itemData) use ($class) {
            return new $class($itemData);
        }, $response->getBody());
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return AbstractEntity
     * @throws GuzzleException
     * @throws ApiException
     */
    protected function requestItem(string $method, string $path, array $params = []): AbstractEntity
    {
        $response = $this->httpRequester->request($method, $path, $params);
        $class = $this->getEntityClass();

        return new $class($response->getBody());
    }

    /**
     * @param string $method
     * @param string $path
     * @param array<string, string> $params
     * @return BasicIdEntity
     * @throws GuzzleException
     * @throws ApiException
     */
    protected function requestId(string $method, string $path, array $params = []): BasicIdEntity
    {
        $response = $this->httpRequester->request($method, $path, $params);

        return new BasicIdEntity($response->getBody());
    }
}