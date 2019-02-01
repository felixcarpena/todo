<?php

declare(strict_types=1);

namespace Todo\Domain\Todo;

use Shared\Domain\AggregateId;
use Shared\Domain\EventSourcingAggregateRoot;
use Todo\Domain\Todo\Create\TodoWasCreated;

final class Todo extends EventSourcingAggregateRoot
{
    /** @var TodoId */
    private $id;
    /** @var string */
    private $description;

    public static function create(TodoId $id, string $description): self
    {
        return (new self())
            ->recordThat(new TodoWasCreated($id, $description));
    }

    public function id(): AggregateId
    {
        return $this->id;
    }

    /** * @return string */
    public function description(): string
    {
        return $this->description;
    }

    protected function applyTodoWasCreated(TodoWasCreated $event): void
    {
        $this->id = $event->aggregateId();
        $this->description = $event->description();
    }
}
