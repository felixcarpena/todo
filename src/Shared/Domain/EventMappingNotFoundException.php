<?php

declare(strict_types=1);

namespace Shared\Domain;

use Throwable;

final class EventMappingNotFoundException extends \Exception
{
    public function __construct(string $eventName, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Mapping for event: '$eventName'' not found", $code, $previous);
    }
}
