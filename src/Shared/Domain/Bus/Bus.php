<?php

declare(strict_types=1);

namespace Shared\Domain\Bus;

use Shared\Domain\Messaging\Message;

interface Bus
{
    public function dispatch(Message $message): void;
}
