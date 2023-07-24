<?php

namespace Service;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Response;
use Kaetan\ApiClient\Entity\Comment;
use Kaetan\ApiClient\Http\HttpRequester;
use Kaetan\ApiClient\Service\CommentService;
use PHPUnit\Framework\TestCase;

class CommentServiceTest extends TestCase
{
    public function testGetComments()
    {
        $code = 200;
        $body = [
            [
                'id' => 1,
                'name' => 'Hej!',
                'text' => 'Hej! This is my comment.',
            ],
            [
                'id' => 2,
                'name' => 'Hola!',
                'text' => 'Hola! This is my comment.',
            ],
            [
                'id' => 3,
                'name' => 'Salut!',
                'text' => 'Salut! This is my comment.',
            ],
        ];

        $response = new Response(
            $code,
            ['content-type' => 'application/json'],
            json_encode($body)
        );

        $requester = new HttpRequester($this->getGuzzleMock($response));
        $service = new CommentService($requester);
        $comments = $service->getComments();
        $comments = array_map(fn (Comment $comment) => $comment->toArray(), $comments);

        $this->assertEquals($body, $comments);
    }

    public function testPostComment()
    {
        $code = 200;
        $body = [
            'id' => 1,
        ];

        $response = new Response(
            $code,
            ['content-type' => 'application/json'],
            json_encode($body)
        );

        $requester = new HttpRequester($this->getGuzzleMock($response));
        $service = new CommentService($requester);
        $result = $service->postComment('Hola!', 'Hola! This is my NEW comment.');

        $this->assertEquals($body, $result->toArray());
    }

    public function testUpdateComment()
    {
        $code = 200;
        $body = [
            'id' => 2,
        ];

        $response = new Response(
            $code,
            ['content-type' => 'application/json'],
            json_encode($body)
        );

        $requester = new HttpRequester($this->getGuzzleMock($response));
        $service = new CommentService($requester);
        $result = $service->updateComment(2, 'Hola!', 'Hola! This is my UPDATED comment.');

        $this->assertEquals($body, $result->toArray());
    }

    protected function getGuzzleMock(Response $response)
    {
        $guzzleStub = $this->createMock(GuzzleClient::class);
        $guzzleStub->method('request')->willReturn($response);
        $guzzleStub->expects($this->atLeastOnce())->method('request');

        return $guzzleStub;
    }
}