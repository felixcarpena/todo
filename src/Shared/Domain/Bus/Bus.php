<?php

declare(strict_types=1);

namespace Shared\Domain\Bus;

use Shared\Domain\Messaging\Message;
use Shared\Domain\Query\QueryResult;

interface Bus
{
    /**
     * @return void|QueryResult
     * @throws \Exception
     */
    public function dispatch(Message $message);
}
