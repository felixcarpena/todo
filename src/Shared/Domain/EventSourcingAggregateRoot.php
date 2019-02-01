<?php

declare(strict_types=1);

namespace Shared\Domain;

use Assert\Assert;

abstract class EventSourcingAggregateRoot
{
    /** @var Events */
    private $events;
    /** @var int */
    private $version;

    protected function __construct()
    {
        $this->version = 0;
        $this->events = new Events();
    }

    abstract public function id(): AggregateId;

    /** @return static */
    public static function fromHistory(AggregateHistory $history): self
    {
        $aggregateRoot = new static();

        foreach ($history->events() as $event) {
            $aggregateRoot->apply($event);
        }

        return $aggregateRoot;
    }

    public function events(): Events
    {
        return $this->events;
    }

    public function version()
    {
        return $this->version;
    }

    /** @return static */
    public function recordThat(Event $event): self
    {
        return $this
            ->addEvent($event)
            ->apply($event);
    }

    /** @return static */
    protected function apply(Event $event): self
    {
        $method = 'apply' . substr(strrchr(get_class($event), '\\'), 1);
        Assert::that($method)->methodExists($this, "Method: $method does not exists");
        $this->$method($event);
        $this->version++;

        return $this;
    }

    /** @return static */
    private function addEvent(Event $event): self
    {
        $this->events->add($event);

        return $this;
    }
}
