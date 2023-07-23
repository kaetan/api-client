<?php

namespace Kaetan\ApiClient\Entities;

/**
 * @property int $id
 * @property string|null $name
 * @property string|null $text
 */
class Comment extends AbstractEntity
{
    /**
     * @return string[]
     */
    protected function getRequiredProperties(): array
    {
        return [
            'id',
            'name',
            'text',
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

}