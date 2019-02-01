<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Ramsey\Uuid\Uuid;
use Shared\Domain\UuidProvider;

final class StandardUuidProvider implements UuidProvider
{
    public function uuid4(): string
    {
        return Uuid::uuid4()->toString();
    }
}
