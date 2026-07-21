# Ivi Config

Configuration loading and management for the IviPHP ecosystem.

## Overview

`iviphp/config` provides a lightweight configuration system for IviPHP packages and applications.

It loads PHP configuration files into a central repository and supports nested values through dot notation.

Each configuration file must return an array.

For example:

```text
config/
├── app.php
├── cache.php
└── database.php
```

The file `config/database.php` becomes available through keys such as:

```php
database.host
database.port
database.connections.mysql
```

## Installation

```bash
composer require iviphp/config
```

## Requirements

- PHP 8.2 or later
- Composer
- `iviphp/support`

## Loading configuration files

```php
<?php

declare(strict_types=1);

use Ivi\Config\Config;

$config = Config::load(__DIR__ . '/config');
```

Each file inside the directory must return an array.

```php
<?php

declare(strict_types=1);

return [
    'name' => 'My Application',
    'environment' => 'production',
    'debug' => false,
];
```

The filename becomes the root configuration key.

```php
$appName = $config->get('app.name');
$debug = $config->get('app.debug', false);
```

## Creating configuration from an array

A repository can also be created directly from an existing array.

```php
<?php

declare(strict_types=1);

use Ivi\Config\Config;

$config = Config::fromArray([
    'app' => [
        'name' => 'My Application',
        'debug' => true,
    ],
]);
```

## Reading configuration values

```php
$name = $config->get('app.name');

$host = $config->get(
    'database.host',
    '127.0.0.1'
);
```

When the key does not exist, the provided default value is returned.

```php
$port = $config->get('database.port', 3306);
```

Retrieve all configuration values:

```php
$items = $config->all();
```

## Checking configuration values

```php
if ($config->has('database.host')) {
    // The configuration key exists.
}
```

## Updating configuration values

```php
$config->set('app.debug', true);

$config->set(
    'database.connections.mysql.host',
    '127.0.0.1'
);
```

## Removing configuration values

```php
$config->forget('app.debug');
```

## Merging configuration values

```php
$config->merge([
    'database' => [
        'port' => 3307,
        'charset' => 'utf8mb4',
    ],
]);
```

Nested arrays are merged recursively.

## Replacing configuration

```php
$config->replace([
    'app' => [
        'name' => 'New Application',
    ],
]);
```

This removes the existing configuration and replaces it entirely.

## Available classes

### `Config`

Loads configuration files or creates a repository from an array.

```php
Config::load($directory);
Config::fromArray($items);
```

### `ConfigRepository`

Stores and manages configuration values.

```php
$config->get($key, $default);
$config->has($key);
$config->set($key, $value);
$config->forget($key);
$config->merge($items);
$config->replace($items);
$config->all();
```

### `ConfigException`

Represents configuration loading failures, including:

- missing configuration directories;
- unreadable directories;
- directory scanning failures;
- configuration files that do not return arrays.

## Design principles

- PHP array configuration files
- Nested access through dot notation
- No global state
- No static configuration repository
- Small and predictable API
- No framework runtime dependency
- Clear exceptions for invalid configuration

This package is responsible only for loading and managing configuration values.

Environment file loading, application bootstrapping and production configuration compilation belong to higher-level IviPHP components.

## Ecosystem

This package is part of the IviPHP ecosystem:

- `iviphp/contracts`
- `iviphp/support`
- `iviphp/container`
- `iviphp/http`
- `iviphp/database`
- `iviphp/validation`
- `iviphp/cache`
- `iviphp/view`
- `iviphp/framework`

## Contributing

Contributions should preserve the focused scope of this package.

New features should:

- remain independent from the full framework;
- avoid global configuration state;
- preserve predictable dot-notation behavior;
- avoid adding unrelated environment or application lifecycle responsibilities.

## Security

Please report security issues privately to the Softadastra maintainers instead of opening a public issue.

## License

This project is licensed under the MIT License.

## Maintainer

Created and maintained by [Softadastra](https://softadastra.com/).
