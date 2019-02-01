<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus;

use Shared\Domain\Bus\Command;
use Shared\Domain\Event;
use Shared\Domain\Messaging\Message;
use Symfony\Component\Messenger\MessageBus;

final class Bus implements \Shared\Domain\Bus\Bus
{
    private $commandBus;
    private $eventBus;

    public function __construct(MessageBus $commandBus, MessageBus $eventBus)
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
    }

    public function dispatch(Message $message): void
    {
        if ($message instanceof Command) {
            $this->commandBus->dispatch($message);
        } elseif ($message instanceof Event) {
            $this->eventBus->dispatch($message);
        }
    }
}
