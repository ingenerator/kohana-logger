# KohanaLogger - Provides PSR-compatible logging and logging enhancements for Kohana

- [![Master Build Status](https://travis-ci.org/ingenerator/kohana-logger.png?branch=master)](https://travis-ci.org/ingenerator/kohana-logger)

KohanaLogger is a small set of classes that provides a PSR-3 compatible interface to the
standard Kohana log, and a few extra logging utility classes.

## Installation

Add config to your composer.json and run `composer update` to install it.

```json
{
  "require": { "ingenerator/kohana-logger": "0.1.*@dev" }
}
```

In your bootstrap:
```php
/**
 * Enable the composer autoloader
 */
require_once(__DIR__.'/../vendor/autoload.php');
```

## Basic Usage

This package is not designed to support kohana-style transparent extension - classes will be loaded by the composer
autoloader. If you want to extend the provided classes, we recommend the use of a 
[service container](https://github.com/zeelot/kohana-dependencies).

To inject the standard Kohana log to a class that takes a PSR3 log instance:

```
$instance = new ThirdPartyClass(new Ingenerator\KohanaLogger\KohanaLogger);
```

By default the class attaches to the global Kohana::$log, but you can provide an instance to attach to if required.


## Testing and developing

kohana-loggers has a full suite of [PhpSpec](http://phpspec.net) specifications. You'll need a skeleton Kohana application to 
run them, you can use [koharness](https://github.com/ingenerator/koharness) to create one. See [travis.yml](travis.yml) for 
the build steps required.

Contributions will only be accepted if they are accompanied by well structured specs. Installing with composer should
get you everything you need to work on the project.

## License

kohana-logger is copyright 2014 inGenerator Ltd and released under the [BSD license](LICENSE).
