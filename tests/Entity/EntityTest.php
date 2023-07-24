<?php

namespace Entity;

use Kaetan\ApiClient\Entity\Comment;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    public function testEntityMapping()
    {
        $id = 10;
        $name = 'Test name';
        $text = 'Test text';
        $comment = new Comment([
            'id' => $id,
            'name' => $name,
            'text' => $text,
        ]);

        $this->assertEquals($id, $comment->getId());
        $this->assertEquals($name, $comment->getName());
        $this->assertEquals($text, $comment->getText());
    }
}