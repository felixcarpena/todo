<?php

declare(strict_types=1);

namespace Tests\Behat\Todo\Context;

use Assert\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Shared\Domain\Bus\Bus;
use Todo\Application\Todo\Create\TodoCreator;
use Todo\Domain\Todo\ReadModel\TodoView;

class TodoContext implements Context
{
    /** @var Bus */
    private $bus;
    /** @var TodoCreator */
    private $todoCreator;
    /** @var TodoView */
    private $todoView;

    public function __construct(Bus $bus, TodoCreator $todoCreator, TodoView $todoView)
    {
        $this->bus = $bus;
        $this->todoCreator = $todoCreator;
        $this->todoView = $todoView;
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
        $todo = $this->todoView->byId($id);

        Assert::that($todo->id())->eq($id);
        Assert::that($todo->description())->eq($description);
    }
}
