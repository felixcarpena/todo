<?php

declare(strict_types=1);

namespace Shared\Domain\Query;

interface QueryHandler
{
    /** @throws \Exception */
    public function handle(Query $query): QueryResult;
}
