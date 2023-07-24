<?php

namespace Kaetan\ApiClient\Entity;

abstract class AbstractEntity
{
    protected array $attributes = [];

    /**
     * @param object|array $data
     */
    public function __construct(object|array $data)
    {
        if (is_array($data)) {
            $data = (object) $data;
        }

        $this->map($data);
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param object $data
     * @return void
     */
    protected function map(object $data): void
    {
        foreach ($this->getRequiredProperties() as $propertyName) {
            if (!property_exists($data, $propertyName)) {
                $this->attributes[$propertyName] = null;
                continue;
            }

            $property = $data->$propertyName;
            $this->attributes[$propertyName] = $property;
        }
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * @return string[]
     */
    protected function getRequiredProperties(): array
    {
        return [];
    }
}