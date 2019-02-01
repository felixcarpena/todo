<?php

declare(strict_types=1);

namespace Shared\Domain;

use Shared\Domain\Messaging\Message;

interface Event extends Message
{
    public function eventName(): string;

    /** @return AggregateId */
    public function aggregateId();

    public function toArrayOfPlainValues(): array;

    /** @return Event */
    public static function fromArray(array $data);
}
