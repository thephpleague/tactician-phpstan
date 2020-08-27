# Tactician-PHPStan

[![Travis CI](https://api.travis-ci.org/thephpleague/tactician-phpstan.svg?branch=master)](https://travis-ci.org/thephpleague/tactician-phpstan)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/badges/build.png?b=master)](https://scrutinizer-ci.com/g/thephpleague/tactician-phpstan/build-status/master)
[![MIT License](https://img.shields.io/badge/license-MIT-brightgreen.svg)](https://github.com/thephpleague/tactician-phpstan/blob/master/LICENSE)

Static analysis for [a small, flexible command bus](https://github.com/thephpleague/tactician).

Traditionally, command buses can obscure static analysis. The Tactician PHPStan plugin helps bring stronger type checking by finding missing handler classes, validating handler return types and more.

## Install

Using Composer:

```sh
composer require --dev league/tactician-phpstan
```

## Register Plugin

If you also install [phpstan/extension-installer](https://github.com/phpstan/extension-installer) then you're all set!

<details>
  <summary>Manual installation</summary>

If you don't want to use `phpstan/extension-installer`, include extension.neon in your project's PHPStan config:

```yaml
includes:
    - vendor/league/tactician-phpstan/extension.neon
```
</details>

## Configuration
You'll need to make your `CommandToHandlerMapping` available to PHPStan. The easiest way to do this is to create a small bootstrap file that returns the same Handler configuration you use in your app. 

A simple version of this might look like:

```php
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
```

You can use your bootstrap file, your DI container or anything else you like, you just need to return a `CommandToHandlerMapping`.

Now expose the bootstrap file in your `phpstan.neon` config. 

```neon
# phpstan.neon
parameters:
    tactician:
        bootstrap: handler-mapping-loader.php
```

And you're good to go!

## Using a different Command Bus class

It's very common to have a bridge interface from your application to any external packages, including Tactician. In that case, you'll have a different command bus class and Tactician-PHPStan won't catch errors because it's looking for usages of the `League\Tactician\CommandBus`.

Instead, you can configure the command bus class to scan for, as well as (optionally) the method to use:

```neon
# phpstan.neon
parameters:
    tactician:
        bootstrap: handler-mapping-loader.php
        class: My\App\CommandBus
        method: execute
```

If neither is specified, the default class is `League\Tactician\CommandBus` and a method named `handle`.

## Testing
To run all unit tests, use the locally installed PHPUnit:

```sh
./vendor/bin/phpunit
```

## Security
Tactician has no previous security disclosures and due to the nature of the project is unlikely to. However, if you're concerned you've found a security sensitive issue in Tactician or one of its related projects, please email disclosures [at] rosstuck dot com.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
