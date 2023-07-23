<?php

namespace Kaetan\ApiClient;

use Kaetan\ApiClient\Http\HttpRequester;
use Kaetan\ApiClient\Service\AbstractService;
use Kaetan\ApiClient\Service\CommentService;
use Kaetan\ApiClient\Service\ServiceFactory;

/**
 * @property CommentService $comments
 */
class Client
{
    /**
     * @var ServiceFactory|null $serviceFactory
     */
    private ServiceFactory|null $serviceFactory = null;

    /**
     * @param string $name
     * @return AbstractService
     */
    public function __get(string $name)
    {
        if ($this->serviceFactory === null) {
            $this->serviceFactory = new ServiceFactory(new HttpRequester());
        }

        return $this->serviceFactory->getService($name);
    }

}