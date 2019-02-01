<?php

declare(strict_types=1);

namespace Todo\Application\Todo\Create;

use Shared\Domain\Bus\Bus;
use Todo\Domain\Todo\Create\CreateTodo;
use Todo\Domain\Todo\TodoIdGenerator;

final class TodoCreator
{
    /** @var TodoIdGenerator */
    private $idGenerator;
    /** @var Bus */
    private $bus;

    public function __construct(TodoIdGenerator $idGenerator, Bus $bus)
    {
        $this->idGenerator = $idGenerator;
        $this->bus = $bus;
    }

    public function create(string $description): void
    {
        $command = new CreateTodo($this->idGenerator->generate(), $description);
        $this->bus->dispatch($command);
    }
}
