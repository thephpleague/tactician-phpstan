<?php
declare(strict_types=1);

namespace MissingHandlerClassForAlternateBus;

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SomeCommand
{

}


class SomeTest extends TestCase
{
}

$builder = new MockBuilder(new SomeTest(), DerpBus::class);
/** @var DerpBus&MockObject $commandBus */
$commandBus = $builder->disableOriginalConstructor()
                ->disableOriginalClone()
                ->disableArgumentCloning()
                ->disallowMockingUnknownTypes()
                ->getMock();

class DerpBus
{
    public function execute(object $command): void
    {

    }
}
$commandBus->expects(TestCase::once())->method('execute') ;
