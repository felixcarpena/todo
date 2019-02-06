<?php

declare(strict_types=1);

namespace Shared\Domain;

interface AggregateId
{
    public function __toString(): string;

    public function value(): string;

    public function equals(AggregateId $item): bool;
}
