<?php

declare(strict_types=1);

namespace Shared\Domain\Query;

use function Lambdish\Phunctional\first;

final class QueryResult implements \IteratorAggregate
{
    /** @var array */
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    public function first()
    {
        return first($this->data);
    }
}
