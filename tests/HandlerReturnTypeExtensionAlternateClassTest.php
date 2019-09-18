<?php
declare(strict_types=1);

namespace League\Tactician\Tests\PHPStan;

use PHPStan\Testing\LevelsTestCase;

/**
 * Test that we can still get Tactician related errors even when we're running
 * this for another command bus class
 */
final class HandlerReturnTypeExtensionAlternateClassTest extends LevelsTestCase
{
    public function dataTopics(): array
    {
        return [
            ['MissingHandlerClassForAlternateBus'],
            ['UnionAndIntersectionClassesBehaveProperly'],
        ];
    }

    public function getDataPath(): string
    {
        return __DIR__.'/data';
    }

    public function getPhpStanExecutablePath(): string
    {
        return __DIR__.'/../vendor/bin/phpstan';
    }

    public function getPhpStanConfigPath(): ?string
    {
        return __DIR__ . '/phpstan-alternate-class.neon';
    }
}
