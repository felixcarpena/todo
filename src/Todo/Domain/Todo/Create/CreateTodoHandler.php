<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\Create;

use Todo\Domain\Todo\Todo;
use Todo\Domain\Todo\TodoRepository;

final class CreateTodoHandler
{
    /** @var TodoRepository */
    private $repository;

    public function __construct(TodoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(CreateTodo $command)
    {
        $todo = Todo::create($command->id(), $command->description());

        $this->repository->save($todo);
    }
}