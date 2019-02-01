<?php

declare(strict_types=1);

namespace spec\Shared\Domain;

use PhpSpec\ObjectBehavior;
use Shared\Domain\Event;
use Shared\Domain\Events;

class EventsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Events::class);
    }

    public function it_should_iterate_over_added_events($event)
    {
        $event->beADoubleOf(Event::class);
        $this->add($event);
        foreach ($this as $event) {
            $event->shouldBe($event);
        }
    }
}
