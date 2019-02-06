<?php

declare(strict_types=1);

namespace Todo\Domain\Todo\ReadModel;

interface TodoView
{
    public function byId(string $id): ?TodoProjection;

    public function save(TodoProjection $todoProjection): void;
}
