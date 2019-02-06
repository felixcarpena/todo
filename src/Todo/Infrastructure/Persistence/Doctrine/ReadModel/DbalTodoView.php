<?php

declare(strict_types=1);

namespace Todo\Infrastructure\Persistence\Doctrine\ReadModel;

use Doctrine\DBAL\Connection;
use Todo\Domain\Todo\ReadModel\TodoProjection;
use Todo\Domain\Todo\ReadModel\TodoView;

final class DbalTodoView implements TodoView
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function byId(string $id): ?TodoProjection
    {
        $stmt = $this->connection->prepare("SELECT * FROM todo where id = :todoId");
        $stmt->execute(['todoId' => $id,]);

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return TodoProjection::fromArray(json_decode($result['data'], true));
    }

    public function save(TodoProjection $todoProjection): void
    {
        $sql = "INSERT INTO todo (id, data) VALUES (:todoId, :data)";
        $sql .= " ON CONFLICT (id) DO UPDATE SET data = EXCLUDED.data";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute(['todoId' => $todoProjection->id(), 'data' => json_encode($todoProjection->toArray())]);
    }
}
