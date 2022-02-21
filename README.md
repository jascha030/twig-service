# Twig Service

Simple set of two interfaces and one basic implementation of a service class for usage
with [Twig](https://github.com/twigphp/Twig).

## Getting Started

### Requirements

* PHP `^8`
* Composer `*` (but preferred `2.2` or later)

### Installation

```shell
composer require jascha030/twig-service
```

## Usage

The package contents consist of one simple service class implementing, an interface, which extends one extra interface
that implements the features that are independent from `twig/twig`.

### TwigServiceInterface

The main interface is the `Jascha030\Twig\TwigServiceInterface`, which requires a class to implement three methods.

#### Methods

**getEnvironment**

Get the TwigEnvironment.

`TwigServiceInterface::getEnvironment(): \Twig\Environment`

* returns `\Twig\Environment` instance.

**Inherited methods**

The methods below are inherited from `Jascha030\Twig\Templater\TemplaterInterface`.

This is done to open future possibility to replace your Twig-specific implementation with another templating method,
without having to refactor your codebase, for example, by using a DIC.

> For this reason, using container bindings bound to the `TemplaterInterface` instead of the `TwigServiceInterface`.
> For the same reason it is recommended to let other classes depend on the `TemplaterInterface`.
> For dependent classes, the fact that the service uses a `Twig\Environment` instance to render the output, should not be relevant.

**renderString**

Render a template and return output as string.

`TemplaterInterface::renderString(string $template, array $context = []): string`

* parameters
    * `$template` (string): the twig template name.
    * `$context` (array): key `=>` pair values corresponding to the template variables.
* returns the rendered template as `string`

**render**

Render and output a template.

`TemplaterInterface::render(string $template, array $context = []): void`

* parameters
    * `$template` (string): the twig template name.
    * `$context` (array): key `=>` pair values corresponding to the template variables.
* returns `void` (output is expected to be echoed).

### Default Implementation

This package also provides class as most-basic implementation of the `TwigServiceInterface`
, `Jascha030\Twig\TwigService.php`. This class implements all three methods with the addition of a constructor requiring
the `Twig\Environment`.

**Below is a simple example of constructing the service with an Environment using the FilesystemLoader:**

```php
<?php

use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Jascha030\Twig\TwigService;

/**
 * Include Composer's autoloader. 
 */
include __DIR__ . '/vendor/autoload.php';

$dir = __DIR__ . '/path/to/your/twig/template/folder';
$environment = new Environment(new FilesystemLoader($dir));
$service = new TwigService($environment);

```

## Development

Clone this repo, and run `composer install` inside the repo.

### Code-style

A code-style is provided in the form of a `php-cs-fixer` configuration in `.php-cs-fixer.dist.php`. For easy execution,
use the provided Composer [script command](https://getcomposer.org/doc/articles/scripts.md).

```shell
composer run format
```

If you have php-cs-fixer installed globally, pass it to the `--config` argument of the `fix` command.

```shell
php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

### Unit-testing

A configuration for `phpunit` is provided in `phpunit.xml`.

For easy execution, use the provided Composer [script command](https://getcomposer.org/doc/articles/scripts.md).

```shell
composer run phpunit
```

If you have phpunit installed globally, and want to use that, pass the config in the `--config` argument.

```shell
phpunit --config phpunit.xml
```

## Motivation

My personal preference is to wrap the `\Twig\Environment` class in a service class, which I was repeatedly writing
again, while it's a very simple class.

So (finally) I added them to a simple package, complete with unit-tests.

## License

This composer package is an open-sourced software licensed under
the [MIT License](https://github.com/jascha030/twig-service/blob/master/LICENSE.md)

> **Note:** to find the right license for your project
> use GitHub's [https://choosealicense.com/](https://choosealicense.com/),
> or read up on any other information, regarding Licensing your project in [their docs' page on licensing](https://docs.github.com/en/github/creating-cloning-and-archiving-repositories/creating-a-repository-on-github/licensing-a-repository).
