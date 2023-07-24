<?php

namespace Kaetan\ApiClient;

use Kaetan\ApiClient\Http\HttpRequester;
use Kaetan\ApiClient\Service\AbstractService;
use Kaetan\ApiClient\Service\CommentService;
use Kaetan\ApiClient\Service\ServiceFactory;
use GuzzleHttp\Client as GuzzleClient;

/**
 * @property CommentService $comments
 */
class Client
{
    private static string $baseUri = 'https://example.com';

    /**
     * @var ServiceFactory|null $serviceFactory
     */
    private ServiceFactory|null $serviceFactory = null;

    /**
     * @param string $name
     * @return AbstractService
     * @throws Exception\ApiException
     */
    public function __get(string $name)
    {
        if ($this->serviceFactory === null) {
            $guzzle = new GuzzleClient(['base_uri' => self::$baseUri]);
            $this->serviceFactory = new ServiceFactory(new HttpRequester($guzzle));
        }

        return $this->serviceFactory->getService($name);
    }

}