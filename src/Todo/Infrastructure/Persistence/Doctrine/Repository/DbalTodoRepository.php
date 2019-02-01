<?php

declare(strict_types=1);

namespace Todo\Infrastructure\Persistence\Doctrine\Repository;

use Shared\Domain\Bus\Bus;
use Shared\Domain\EventStore;
use Todo\Domain\Todo\Todo;
use Todo\Domain\Todo\TodoId;
use Todo\Domain\Todo\TodoRepository;

final class DbalTodoRepository implements TodoRepository
{
    /** @var EventStore */
    private $eventStore;
    /** @var Bus */
    private $bus;

    public function __construct(EventStore $eventStore, Bus $bus)
    {
        $this->eventStore = $eventStore;
        $this->bus = $bus;
    }

    public function get(TodoId $todoId): Todo
    {
       $history = $this->eventStore->load($todoId);

       return Todo::fromHistory($history);

    }

    public function save(Todo $todo): void
    {
        $events = $todo->events();
        $this->eventStore->add($todo->id(), $events);
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }
}
