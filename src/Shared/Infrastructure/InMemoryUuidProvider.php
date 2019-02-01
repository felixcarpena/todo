<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Shared\Domain\UuidProvider;

final class InMemoryUuidProvider implements UuidProvider
{
    /** @var array */
    private $values;

    public function __construct()
    {
        $this->values = ['uuid4' => []];
    }

    public function addUuid4(string $value): void
    {
        $this->values['uuid4'][] = $value;
    }

    public function uuid4(): string
    {
        return array_pop($this->values['uuid4']);
    }
}
