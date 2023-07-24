<?php

namespace Http;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Kaetan\ApiClient\Http\ApiResponse;
use Kaetan\ApiClient\Http\HttpRequester;
use PHPUnit\Framework\TestCase;

class RequesterTest extends TestCase
{
    public function testCreateRequester()
    {
        $requester = new HttpRequester(new GuzzleClient(['base_uri' => 'https://example.com']));

        $this->assertInstanceOf(\GuzzleHttp\Client::class, $requester->guzzleClient);
        $this->assertEquals('https://example.com', $requester->guzzleClient->getConfig('base_uri'));
    }

    public function testProcessResponse()
    {
        $requester = new HttpRequester(new GuzzleClient(['base_uri' => 'https://example.com']));
        $body = 'Success';
        $code = 200;
        $responseSuccess = new Response(
            $code,
            ['content-type' => 'application/json'],
            json_encode($body)
        );
        $apiResponse = $requester->processResponse($responseSuccess);

        $this->assertInstanceOf(ApiResponse::class, $apiResponse);
        $this->assertEquals($code, $apiResponse->getCode());
        $this->assertEquals($body, $apiResponse->getBody());
    }

}