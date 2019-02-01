<?php

declare(strict_types=1);

namespace Tests\Behat\Todo\Context;

use Assert\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Shared\Domain\Bus\Bus;
use Todo\Application\Todo\Create\TodoCreator;
use Todo\Domain\Todo\TodoId;
use Todo\Domain\Todo\TodoRepository;

class TodoContext implements Context
{
    /** @var Bus */
    private $bus;
    /** @var TodoCreator */
    private $todoCreator;
    /** @var TodoRepository */
    private $todoRepository;

    public function __construct(Bus $bus, TodoCreator $todoCreator, TodoRepository $todoRepository)
    {
        $this->bus = $bus;
        $this->todoCreator = $todoCreator;
        $this->todoRepository = $todoRepository;
    }

    /**
     * @When it create a todo with data:
     */
    public function itCreateATodoWithData(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->todoCreator->create($row['description']);
        }
    }

    /**
     * @Then the todo: :id and description: :description should exist
     */
    public function theTodoAndDescriptionShouldExist(string $id, string $description)
    {
        $todo = $this->todoRepository->get(new TodoId($id));

        Assert::that($todo->id())->eq($id);
        Assert::that($todo->description())->eq($description);
    }
}
