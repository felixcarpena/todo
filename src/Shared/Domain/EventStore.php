<?php

declare(strict_types=1);

namespace Shared\Domain;

interface EventStore
{
    public function load(AggregateId $aggregateId): AggregateHistory;

    public function add(AggregateId $aggregateId, Events $events): void;
}
