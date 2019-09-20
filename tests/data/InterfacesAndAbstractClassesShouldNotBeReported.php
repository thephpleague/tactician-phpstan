<?php
declare(strict_types=1);

namespace InterfacesAndAbstractClassesShouldNotBeReported;

use League\Tactician\CommandBus;

interface Command
{
}

abstract class DoIt implements Command
{
}

$command = require 'InterfacesAndAbstractClassesShouldNotBeReported_data.php';
/** @var Command $commandInterfaceTypehinted */
$commandInterfaceTypehinted = $command;
/** @var DoIt $commandAbstractTypehinted */
$commandAbstractTypehinted = $command;

$commandBus = new CommandBus();
$commandBus->handle($commandInterfaceTypehinted);
$commandBus->handle($commandAbstractTypehinted);
