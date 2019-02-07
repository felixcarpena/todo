<?php

namespace Tests\unit\Todo\Application\Todo\Create;

use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Shared\Domain\Bus\Bus;
use Shared\Domain\IdGenerator;
use Tests\Tools\Stub;
use Tests\Tools\Todo\Domain\Todo\TodoIdStub;
use Todo\Application\Todo\Create\TodoCreator;
use Todo\Domain\Todo\Create\CreateTodo;
use Todo\Domain\Todo\TodoIdGenerator;

class TodoCreatorTest extends TestCase
{
    /** @var TodoIdGenerator|ObjectProphecy */
    private $idGenerator;
    /** @var Bus|ObjectProphecy */
    private $bus;
    /** @var TodoCreator */
    private $sut;

    /** @test */
    public function create()
    {
        $todoId = TodoIdStub::random();
        $description = Stub::random()->words(3, true);

        $this->idGenerator->generate()
            ->willReturn($todoId);

        $this->sut->create($description);

        $this->bus->dispatch(new CreateTodo($todoId, $description))
            ->shouldHaveBeenCalled();
    }

    protected function setUp(): void
    {
        $this->idGenerator = $this->prophesize(IdGenerator::class);
        $this->bus = $this->prophesize(Bus::class);
        $this->sut = new TodoCreator(
            $this->idGenerator->reveal(),
            $this->bus->reveal()
        );
    }
}
