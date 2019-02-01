<?php

declare(strict_types=1);

namespace Shared\Domain;

interface EventResolver
{
    /** @throws EventMappingNotFoundException */
    public function fromMessageName(string $name): string;
}
