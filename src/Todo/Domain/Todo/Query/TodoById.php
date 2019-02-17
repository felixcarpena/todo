<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\Query;

use Shared\Domain\Query\Query;
use Todo\Domain\Todo\TodoId;

final class TodoById implements Query
{
    /** @var TodoId */
    private $todoId;

    public function __construct(TodoId $todoId)
    {
        $this->todoId = $todoId;
    }

    public function todoId(): TodoId
    {
        return $this->todoId;
    }
}
