<?php

declare(strict_types=1);

namespace Tests\Behat\Todo\Context;

use Assert\Assert;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Shared\Domain\Bus\Bus;
use Todo\Application\Todo\Create\TodoCreator;
use Todo\Domain\Todo\Query\TodoById;
use Todo\Domain\Todo\ReadModel\TodoProjection;
use Todo\Domain\Todo\ReadModel\TodoView;
use Todo\Domain\Todo\TodoId;

class TodoContext implements Context
{
    /** @var Bus */
    private $bus;
    /** @var TodoCreator */
    private $todoCreator;

    public function __construct(Bus $bus, TodoCreator $todoCreator)
    {
        $this->bus = $bus;
        $this->todoCreator = $todoCreator;
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
        $result = $this->bus->dispatch(new TodoById(new TodoId($id)));
        /** @var TodoProjection $todoProjection */
        $todoProjection = $result->first();

        Assert::that($todoProjection->id())->eq($id);
        Assert::that($todoProjection->description())->eq($description);
    }
}
