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
        $tablesToBeCleaned = ['event_store', 'todo'];
        $conn = $this->kernel->getContainer()->get('database_connection');
        foreach ($tablesToBeCleaned as $table) {
            $conn->executeQuery("TRUNCATE TABLE $table RESTART IDENTITY");
        }
    }
}
