<?php

declare(strict_types=1);

namespace Tests\Behat\Shared\Context;

use Behat\Behat\Context\Context;
use Shared\Infrastructure\InMemoryUuidProvider;

class IdGeneratorContext implements Context
{
    /** @var InMemoryUuidProvider */
    private $idGenerator;

    public function __construct(InMemoryUuidProvider $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }

    /**
     * @Given todo next Id generator will return: :id
     */
    public function todoNextIdGeneratorWillReturn(string $id)
    {
        $this->idGenerator->addUuid4($id);
    }
}
