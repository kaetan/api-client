<?php

use Kaetan\ApiClient\Client;
use Kaetan\ApiClient\Exception\ApiException;
use Kaetan\ApiClient\Service\CommentService;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGetService()
    {
        $client = new Client();
        $commentService = $client->comments;

        $this->assertInstanceOf(CommentService::class, $commentService);
    }

    public function testFailedToGetService()
    {
        $this->expectException(ApiException::class);

        $client = new Client();
        $commentService = $client->wrongService;
    }
}