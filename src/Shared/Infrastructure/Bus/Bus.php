<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus;

use Shared\Domain\Bus\Command;
use Shared\Domain\Event;
use Shared\Domain\Messaging\Message;
use Shared\Domain\Query\Query;
use Shared\Domain\Query\QueryResult;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class Bus implements \Shared\Domain\Bus\Bus
{
    private $commandBus;
    private $eventBus;
    private $queryBus;

    public function __construct(MessageBus $commandBus, MessageBus $eventBus, MessageBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->eventBus = $eventBus;
        $this->queryBus = $queryBus;
    }

    /**
     * @return void|QueryResult
     * @throws \Exception
     */
    public function dispatch(Message $message)
    {
        if ($message instanceof Command) {
            $this->commandBus->dispatch($message);
        } elseif ($message instanceof Event) {
            $this->eventBus->dispatch($message);
        } elseif ($message instanceof Query) {
            $envelope = $this->queryBus->dispatch($message);

            $handledStamp = $envelope->last(HandledStamp::class);
            return $handledStamp->getResult();
        }else{
            throw new \Exception("Bus message not supported!");
        }
    }
}
