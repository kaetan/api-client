<?php

namespace Kaetan\ApiClient\Service;

use Kaetan\ApiClient\Http\HttpRequester;

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

    public function __construct(protected HttpRequester $httpRequester)
    {
    }

    /**
     * @param string $name
     * @return AbstractService|null
     */
    public function getService(string $name): AbstractService|null
    {
        $serviceClass = array_key_exists($name, self::$serviceClassMap) ? self::$serviceClassMap[$name] : null;

        if ($serviceClass === null) {
            trigger_error('Unknown resource: ' . $name);

            return null;
        }

        if (!array_key_exists($name, $this->services)) {
            $this->services[$name] = new $serviceClass($this->httpRequester);
        }

        return $this->services[$name];
    }
}