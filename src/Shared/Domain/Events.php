<?php

declare(strict_types=1);

namespace Shared\Domain;

final class Events implements \IteratorAggregate
{
    /** @var Event[] */
    private $events;

    public function __construct(Event ...$events)
    {
        $this->events = $events;
    }

    public function add(Event $event): void
    {
        $this->events[] = $event;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }

}
