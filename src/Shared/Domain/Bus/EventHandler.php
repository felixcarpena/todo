<?php

declare(strict_types=1);

namespace Shared\Domain\Bus;

use Shared\Domain\Messaging\Message;

interface EventHandler
{
    /** @throws \Exception */
    public function on(Message $message);
}
