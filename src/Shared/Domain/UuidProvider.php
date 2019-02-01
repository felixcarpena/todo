<?php

declare(strict_types=1);

namespace Shared\Domain;

interface UuidProvider
{
    public function uuid4(): string;
}
