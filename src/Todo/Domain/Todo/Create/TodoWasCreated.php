<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\Create;

use Shared\Domain\Event;
use Todo\Domain\Todo\TodoId;

final class TodoWasCreated implements Event
{
    const EVENT_NAME = 'todo.todo_was_created';

    /** @var TodoId */
    private $id;
    /** @var string */
    private $description;

    public function __construct(TodoId $id, string $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public static function fromArray(array $data): self
    {
        return new self(new TodoId($data['aggregate_id']), $data['description']);
    }

    public function aggregateId(): TodoId
    {
        return $this->id;
    }

    /** * @return string */
    public function description(): string
    {
        return $this->description;
    }

    public function eventName(): string
    {
        return self::EVENT_NAME;
    }

    public function toArrayOfPlainValues(): array
    {
        return [
            'aggregate_id' => (string)$this->id,
            'description' => $this->description,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArrayOfPlainValues();
    }
}
