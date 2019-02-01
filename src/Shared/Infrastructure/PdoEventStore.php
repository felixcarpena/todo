<?php

declare(strict_types=1);

namespace Shared\Infrastructure;

use Doctrine\DBAL\Connection;
use Shared\Domain\AggregateHistory;
use Shared\Domain\AggregateId;
use Shared\Domain\Event;
use Shared\Domain\Events;
use Shared\Domain\EventSerializer;
use Shared\Domain\EventStore;

final class PdoEventStore implements EventStore
{
    /** @var Connection */
    private $connection;
    /** @var EventSerializer */
    private $eventSerializer;

    public function __construct(Connection $connection, EventSerializer $eventSerializer)
    {
        $this->connection = $connection;
        $this->eventSerializer = $eventSerializer;
    }

    public function load(AggregateId $id): AggregateHistory
    {
        $sql = "SELECT data FROM event_store WHERE data->'payload'->>'aggregate_id' = :id ORDER BY id ASC";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['id' => (string)$id]);

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $events = new Events();
        foreach ($rows as $row) {
            $event = $this->eventSerializer->deserialize($row['data']);
            $events->add($event);
        }

        return new AggregateHistory($id, $events);
    }

    public function add(AggregateId $aggregateId, Events $events): void
    {
        $this->connection->transactional(function (Connection $connection) use ($events) {
            $stmt = $connection->prepare("INSERT INTO event_store (data) VALUES (:message)");
            /** @var Event $event */
            foreach ($events as $event) {
                $data = $this->eventSerializer->serialize($event);
                $stmt->execute(['message' => json_encode($data)]);
            }
        });
    }
}
