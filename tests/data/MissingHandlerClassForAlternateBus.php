<?php
declare(strict_types=1);

namespace MissingHandlerClassForAlternateBus;

class SomeCommand
{

}

class DerpBus
{
    public function handle(object $command): void
    {

    }
}

$commandBus = new DerpBus();
$commandBus->handle(new SomeCommand());
