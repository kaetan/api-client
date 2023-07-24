<?php

namespace Kaetan\ApiClient\Service;

use Kaetan\ApiClient\Exception\ApiException;
use Kaetan\ApiClient\Http\RequesterInterface;

class ServiceFactory
{
    /**
     * @var array<string, string>
     */
    private static array $serviceClassMap = [
        'comments' => CommentService::class,
    ];

    /**
     * @var array<string, AbstractService>
     */
    private array $services = [];

    public function __construct(protected RequesterInterface $httpRequester)
    {
    }

    /**
     * @param string $name
     * @return AbstractService|null
     * @throws ApiException
     */
    public function getService(string $name): AbstractService|null
    {
        $serviceClass = array_key_exists($name, self::$serviceClassMap) ? self::$serviceClassMap[$name] : null;

        if ($serviceClass === null) {
            throw new ApiException('Unknown resource: ' . $name);
        }

        if (!array_key_exists($name, $this->services)) {
            $this->services[$name] = new $serviceClass($this->httpRequester);
        }

        return $this->services[$name];
    }
}