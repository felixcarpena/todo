<?php

declare(strict_types=1);

namespace spec\Todo\Domain\Todo;

use Assert\InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Shared\Domain\Event;
use Shared\Domain\Events;
use Tests\Tools\Stub;
use Tests\Tools\Todo\Domain\Todo\TodoIdStub;
use Todo\Domain\Todo\Create\TodoWasCreated;
use Todo\Domain\Todo\Todo;
use Todo\Domain\Todo\TodoId;

class TodoSpec extends ObjectBehavior
{
    /** @var TodoId */
    private $todoId;
    /** @var string */
    private $description;

    public function let()
    {
        $this->todoId = TodoIdStub::random();
        $this->description = Stub::random()->text;

        $this->beConstructedThrough('create', [$this->todoId, $this->description]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Todo::class);
    }

    public function it_is_created()
    {
        $expectedEvents = new Events(new TodoWasCreated($this->todoId, $this->description));
        $this->events()->shouldBeLike($expectedEvents);
        $this->id()->shouldBe($this->todoId);
        $this->description()->shouldBe($this->description);
    }

    public function it_should_increase_version()
    {
        $this->version()->shouldBe(1);
    }

    public function it_throw_exception_when_method_apply_does_not_exists($event)
    {
        $event->beADoubleOf(Event::class);
        $this->shouldThrow(InvalidArgumentException::class)->during('recordThat', [$event]);
    }
}
