<?php

declare(strict_types=1);

namespace Shared\Domain\Messaging;

interface AsyncMessage extends Message
{
    /** @return static */
    public static function fromArray(array $data);

    public function toArrayOfPlainValues(): array;
}
