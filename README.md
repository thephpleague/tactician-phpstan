# Tactician-PHPStan

[![Travis CI](https://api.travis-ci.org/thephpleague/tactician-phpstan.svg?branch=master)](https://travis-ci.org/thephpleague/tactician-phpstan)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/build.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/build-status/master)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/thephpleague/tactician-phpstan/blob/master/LICENSE)

Static analysis for a small, pluggable command bus.

Traditionally, command buses can obscure static analysis. The Tactician PHPStan plugin helps bring stronger type checking by finding missing handler classes, validating handler return types and more.

See the [full docs](http://tactician.thephpleague.com) or the examples directory to get started.

## Install

Using Composer:

`composer require league/tactician-phpstan`

## Setup
You'll need to make your `CommandToHandlerMapping` available to PHPStan. The easiest way to do this is to create a small bootstrap file that returns the same Handler configuration you use in your app. 

A simple version of this might look like:

~~~
# handler-mapper-loader.php
<?php

require_once __DIR__.'/vendor/autoload.php';

use League\Tactician\Handler\Mapping\ClassName\Suffix;
use League\Tactician\Handler\Mapping\MapByNamingConvention;
use League\Tactician\Handler\Mapping\MethodName\Handle;

return new MapByNamingConvention(
    new Suffix('Handler'),
    new Handle()
);
~~~

You can use your bootstrap file, your DI container or anything else you like, you just need to return a `CommandToHandlerMapping`.

Now expose the bootstrap file in your `phpstan.neon` config. 

~~~
# phpstan.neon
parameters:
    tactician:
        bootstrap: handler-mapping-loader.php
~~~

And you're good to go!

## Testing
To run all unit tests, use the locally installed PHPUnit:

~~~
$ ./vendor/bin/phpunit
~~~

## Security
Tactician has no previous security disclosures and due to the nature of the project is unlikely to. However, if you're concerned you've found a security sensitive issue in Tactician or one of its related projects, please email disclosures [at] rosstuck dot com.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
