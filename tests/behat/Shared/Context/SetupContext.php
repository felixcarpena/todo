<?php

declare(strict_types=1);

namespace Tests\Behat\Shared\Context;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;

final class SetupContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /** @BeforeSuite */
    public static function createDatabase()
    {
        $console = "APP_ENV=test php " . __DIR__ . '/../../../../bin/console';
        exec("$console doctrine:database:drop --force --no-interaction");
        exec("$console doctrine:database:create --no-interaction");
        exec("$console doctrine:migrations:migrate --no-interaction");
    }

    /** @BeforeScenario */
    public function cleanTables()
    {
        $conn = $this->kernel->getContainer()->get('database_connection');
        $conn->executeQuery('TRUNCATE TABLE event_store RESTART IDENTITY');
    }
}
