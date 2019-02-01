<?php

declare(strict_types=1);

namespace Shared\Domain;

interface IdGenerator
{
    public function generate(): AggregateId;
}
