<?php

declare(strict_types=1);

namespace Shared\Domain;

interface Event extends Messaging\AsyncMessage
{
    public function eventName(): string;

    /** @return AggregateId */
    public function aggregateId();

    public function toArrayOfPlainValues(): array;

    /** @return Event */
    public static function fromArray(array $data);
}
