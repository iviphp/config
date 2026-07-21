<?php

declare(strict_types=1);

/**
 *
 * @file Config.php
 * @author Gaspard Kirira
 *
 * Copyright 2026, Gaspard Kirira.
 * All rights reserved.
 * https://github.com/iviphp/config
 *
 * Use of this source code is governed by an MIT license
 * that can be found in the LICENSE file.
 *
 * IviPHP
 *
 */

namespace Ivi\Config;

use Ivi\Config\Exceptions\ConfigException;

/**
 * @class Config
 *
 * @brief Loads PHP configuration files into a configuration repository.
 *
 * Each configuration file must return an array. The filename becomes
 * the root configuration key.
 *
 * Example:
 *
 * `config/database.php` becomes accessible through `database.host`.
 *
 * @since 0.1.0
 */
final class Config
{
    /**
     * Prevent utility class instantiation.
     */
    private function __construct() {}

    /**
     * @brief Load configuration files from a directory.
     *
     * @param string $directory Directory containing PHP configuration files.
     *
     * @return ConfigRepository Loaded configuration repository.
     *
     * @throws ConfigException When the directory is missing, unreadable,
     *                         or a file does not return an array.
     */
    public static function load(string $directory): ConfigRepository
    {
        if (!is_dir($directory)) {
            throw ConfigException::directoryNotFound($directory);
        }

        if (!is_readable($directory)) {
            throw ConfigException::directoryNotReadable($directory);
        }

        $files = glob(rtrim($directory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '*.php');

        if ($files === false) {
            throw ConfigException::cannotReadDirectory($directory);
        }

        sort($files, SORT_NATURAL);

        $items = [];

        foreach ($files as $file) {
            $name = pathinfo($file, PATHINFO_FILENAME);
            $value = require $file;

            if (!is_array($value)) {
                throw ConfigException::invalidFile($file);
            }

            $items[$name] = $value;
        }

        return new ConfigRepository($items);
    }

    /**
     * @brief Create a repository from an existing array.
     *
     * @param array<string, mixed> $items Configuration values.
     *
     * @return ConfigRepository
     */
    public static function fromArray(array $items): ConfigRepository
    {
        return new ConfigRepository($items);
    }
}
