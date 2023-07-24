<?php

namespace Kaetan\ApiClient\Entity;

/**
 * @property int $id
 */
class BasicIdEntity extends AbstractEntity
{
    protected function getRequiredProperties(): array
    {
        return [
            'id',
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}