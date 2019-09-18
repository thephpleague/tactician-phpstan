<?php
declare(strict_types=1);

namespace League\Tactician\PHPStan;

use League\Tactician\Handler\Mapping\CommandToHandlerMapping;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Broker\Broker;
use PHPStan\Broker\ClassNotFoundException;
use PHPStan\Reflection\BrokerAwareExtension;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MissingMethodFromReflectionException;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

final class HandlerReturnTypeExtension implements DynamicMethodReturnTypeExtension, BrokerAwareExtension
{
    /**
     * @var Broker
     */
    private $broker;
    /**
     * @var CommandToHandlerMapping
     */
    private $mapping;
    /**
     * @var string
     */
    private $commandBusClass;
    /**
     * @var string
     */
    private $commandBusMethod;

    public function __construct(CommandToHandlerMapping $mapping, string $commandBusClass, string $commandBusMethod)
    {
        $this->mapping = $mapping;
        $this->commandBusClass = $commandBusClass;
        $this->commandBusMethod = $commandBusMethod;
    }

    public function setBroker(Broker $broker): void
    {
        $this->broker = $broker;
    }

    public function getClass(): string
    {
        return $this->commandBusClass;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === $this->commandBusMethod;
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope
    ): Type {
        $commandType = $scope->getType($methodCall->args[0]->value);

        if (! $commandType instanceof ObjectType) {
            return new MixedType();
        }

        try {
            $handlerClass = $this->broker->getClass(
                $this->mapping->getClassName($commandType->getClassName())
            );
        } catch (ClassNotFoundException $e) {
            return new MixedType();
        }

        $methodName = $this->mapping->getMethodName($commandType->getClassName());

        try {
            $method = $handlerClass->getMethod($methodName, $scope)->getVariants();
        } catch (MissingMethodFromReflectionException $e) {
            return new MixedType();
        }

        return ParametersAcceptorSelector::selectFromArgs($scope, $methodCall->args, $method)->getReturnType();
    }
}
