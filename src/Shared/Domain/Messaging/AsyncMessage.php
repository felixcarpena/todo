<?php

declare(strict_types=1);

namespace Shared\Domain\Messaging;

interface AsyncMessage extends Message
{
    public function topic(): string;

    /** @return static */
    public static function fromArray(array $data);

    public function toArrayOfPlainValues(): array;
}
