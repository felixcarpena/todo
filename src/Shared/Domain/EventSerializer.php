<?php

declare(strict_types=1);

namespace Shared\Domain;

final class EventSerializer
{
    /** @var EventResolver */
    private $eventResolver;

    public function __construct(EventResolver $eventResolver)
    {
        $this->eventResolver = $eventResolver;
    }

    public function serialize(Event $event): array
    {
        return [
            'name' => $event->eventName(),
            'payload' => $event->toArrayOfPlainValues()
        ];
    }

    public function deserialize(string $plainEventData): Event
    {
        $data = json_decode($plainEventData, true);
        $eventClass = $this->eventResolver->fromMessageName($data['name']);

        return $eventClass::fromArray($data['payload']);
    }
}
