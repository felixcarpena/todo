<?php

declare(strict_types=1);

namespace Shared\Domain\Query;

abstract class BaseQueryHandler implements QueryHandler
{
    /** @throws \Exception */
    public function handle(Query $query): QueryResult
    {
        $method = 'handle' . substr(strrchr(get_class($query), '\\'), 1);
        if (!method_exists($this, $method)) {
            $errorMessage = sprintf(
                'Impossible to call method: %s in class: %s', $method, get_class($this)
            );
            throw new \Exception($errorMessage);
        }
        
        return $this->$method($query);
    }
}
