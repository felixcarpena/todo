<?php

declare(strict_types=1);

namespace Todo\Domain\Todo;

use Shared\Domain\AggregateId;
use Shared\Domain\IdGenerator;
use Shared\Domain\UuidProvider;

final class TodoIdGenerator implements IdGenerator
{
    /** @var UuidProvider */
    private $uuidProvider;

    public function __construct(UuidProvider $uuidProvider)
    {
        $this->uuidProvider = $uuidProvider;
    }

    /** @return TodoId|AggregateId */
    public function generate(): AggregateId
    {
        return new TodoId($this->uuidProvider->uuid4());
    }
}
