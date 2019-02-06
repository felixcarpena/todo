<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\ReadModel;

use Shared\Domain\Bus\BaseEventHandler;
use Shared\Domain\ReadModel\Projector;
use Todo\Domain\Todo\Create\TodoWasCreated;

final class TodoProjector extends BaseEventHandler implements Projector
{
    /** @var TodoView */
    private $todoView;

    public function __construct(TodoView $todoView)
    {
        $this->todoView = $todoView;
    }

    public function onTodoWasCreated(TodoWasCreated $event)
    {
        $projection = new TodoProjection($event->aggregateId()->value(), $event->description());

        $this->todoView->save($projection);
    }
}
