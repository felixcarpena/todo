<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\ReadModel;

final class TodoProjection
{
    /** @var string */
    private $id;
    /** @var string */
    private $description;

    public function __construct(string $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function toArray()
    {
        return [
            'id' => $this->id(),
            'description' => $this->description(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['id'], $data['description']);
    }
}
