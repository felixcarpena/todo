<?php

declare(strict_types=1);

namespace Tests\Tools\Todo\Domain\Todo;

use Tests\Tools\Stub;
use Todo\Domain\Todo\TodoId;

final class TodoIdStub
{
    public static function random(): TodoId
    {
        return new TodoId(Stub::random()->uuid);
    }
}