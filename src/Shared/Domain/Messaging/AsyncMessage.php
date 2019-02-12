<?php

declare(strict_types=1);

namespace Shared\Domain\Messaging;

interface AsyncMessage extends Message, \JsonSerializable
{

}
