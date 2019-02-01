<?php

declare(strict_types=1);

namespace Shared\Domain;

final class AggregateHistory
{
    /** @var AggregateId */
    private $aggregateId;
    /** @var Events */
    private $events;

    public function __construct(AggregateId $aggregateId, Events $events)
    {
        $this->aggregateId = $aggregateId;
        $this->events = $events;
    }

    /** * @return AggregateId */
    public function aggregateId(): AggregateId
    {
        return $this->aggregateId;
    }

    /** * @return Events */
    public function events(): Events
    {
        return $this->events;
    }
}
