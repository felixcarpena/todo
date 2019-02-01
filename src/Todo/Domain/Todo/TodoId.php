<?php

declare(strict_types=1);

namespace Todo\Domain\Todo;

use Assert\Assert;
use Shared\Domain\AggregateId;

final class TodoId implements AggregateId
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(AggregateId $item): bool
    {
        Assert::that($item)->isInstanceOf(static::class);
        $item->value === $this->value;
    }
}
