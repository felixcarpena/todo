<?php

declare(strict_types=1);

namespace Tests\Tools;

use Faker\Factory;
use Faker\Generator;

final class Stub
{
    /**@var Generator */
    private static $faker;
    /** @var int */
    private static $seed;

    public static function random(): Generator
    {
        return self::$faker ?? self::initFaker();
    }

    public static function seed(): ?int
    {
        return self::$seed;
    }

    public static function resetSeed(): void
    {
        if (self::$faker !== null) {
            self::setSeed(self::generateSeed());
        }
    }

    public static function setSeed(int $seed): void
    {
        self::random()->seed($seed);
        \srand($seed);
        self::$seed = $seed;
    }

    private static function initFaker(): Generator
    {
        self::$faker = Factory::create('es_ES');
        self::resetSeed();

        return self::$faker;
    }

    private static function generateSeed(): int
    {
        list($microSeconds, $seconds) = explode(' ', microtime());

        return (int) ($seconds + $microSeconds * 1000000);
    }
}