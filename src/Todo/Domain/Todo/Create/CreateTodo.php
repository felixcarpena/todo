<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\Create;

use Shared\Domain\Bus\Command;
use Todo\Domain\Todo\TodoId;

final class CreateTodo implements Command
{
    /** @var TodoId */
    private $id;
    /** @var string */
    private $description;

    public function __construct(TodoId $id, $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    /** * @return TodoId */
    public function id(): TodoId
    {
        return $this->id;
    }

    /** * @return mixed */
    public function description()
    {
        return $this->description;
    }
}
