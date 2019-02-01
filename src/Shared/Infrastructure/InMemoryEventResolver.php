<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Shared\Domain\EventMappingNotFoundException;
use Shared\Domain\EventResolver;
use Todo\Domain\Todo\Create\TodoWasCreated;

final class InMemoryEventResolver implements EventResolver
{
    private $map;

    public function __construct()
    {
        $this->map = [
            TodoWasCreated::EVENT_NAME => TodoWasCreated::class,
        ];
    }

    public function fromMessageName(string $name): string
    {
        if (!isset($this->map[$name])) {
            throw new EventMappingNotFoundException($name);
        }

        return $this->map[$name];
    }
}
