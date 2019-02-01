<?php

declare(strict_types=1);

namespace Todo\Domain\Todo;

interface TodoRepository
{
    public function get(TodoId $todoId): Todo;

    public function save(Todo $todo): void;
}