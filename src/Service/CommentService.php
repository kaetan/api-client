<?php

namespace Kaetan\ApiClient\Service;

use Kaetan\ApiClient\Entity\BasicIdEntity;
use Kaetan\ApiClient\Entity\Comment;
use Kaetan\ApiClient\Exception\ApiException;

class CommentService extends AbstractService
{
    /**
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Comment::class;
    }

    /**
     * @return Comment[]
     * @throws ApiException
     */
    public function getComments(): array
    {
        return $this->requestList('GET', 'comments');
    }

    /**
     * @param string $name
     * @param string $text
     * @return BasicIdEntity
     * @throws ApiException
     */
    public function postComment(string $name, string $text): BasicIdEntity
    {
        $data = [
            'name' => $name,
            'text' => $text,
        ];

        return $this->requestId('POST', 'comment', $data);
    }

    /**
     * @param int $id
     * @param string|null $name
     * @param string|null $text
     * @return BasicIdEntity
     * @throws ApiException
     */
    public function updateComment(int $id, string|null $name = null, string|null $text = null): BasicIdEntity
    {
        $data = [
            'name' => $name,
            'text' => $text,
        ];

        return $this->requestId('PUT', 'comment/' . $id, array_filter($data));
    }

}