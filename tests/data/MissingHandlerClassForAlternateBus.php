<?php
declare(strict_types=1);

namespace MissingHandlerClassForAlternateBus;

class SomeCommand
{

}

class DerpBus
{
    public function execute(object $command): void
    {

    }
}

$commandBus = new DerpBus();
$commandBus->execute(new SomeCommand());
