<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\Query;

use Shared\Domain\Query\BaseQueryHandler;
use Shared\Domain\Query\QueryResult;
use Todo\Domain\Todo\ReadModel\TodoView;

final class TodoQueryHandler extends BaseQueryHandler
{
    /** @var TodoView */
    private $todoView;

    public function __construct(TodoView $todoView)
    {
        $this->todoView = $todoView;
    }

    public function handleTodoById(TodoById $query): QueryResult
    {
        return new QueryResult([$this->todoView->byId((string) $query->todoId())]);
    }
}
