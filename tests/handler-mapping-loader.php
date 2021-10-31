<?php

use League\Tactician\Handler\Mapping\MapByNamingConvention\ClassName\Suffix;
use League\Tactician\Handler\Mapping\MapByNamingConvention\MapByNamingConvention;
use League\Tactician\Handler\Mapping\MapByNamingConvention\MethodName\Handle;

return new MapByNamingConvention(
    new Suffix('Handler'),
    new Handle()
);
