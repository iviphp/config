<?php

declare(strict_types=1);

/**
 *
 * @file ConfigException.php
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

namespace Ivi\Config\Exceptions;

/**
 * @class ConfigException
 *
 * @brief Represents configuration loading and validation failures.
 *
 * @since 0.1.0
 */
final class ConfigException extends \RuntimeException
{
    /**
     * @brief Create an exception for a missing configuration directory.
     */
    public static function directoryNotFound(string $directory): self
    {
        return new self(
            "Configuration directory not found: {$directory}"
        );
    }

    /**
     * @brief Create an exception for an unreadable configuration directory.
     */
    public static function directoryNotReadable(string $directory): self
    {
        return new self(
            "Configuration directory is not readable: {$directory}"
        );
    }

    /**
     * @brief Create an exception when a directory cannot be scanned.
     */
    public static function cannotReadDirectory(string $directory): self
    {
        return new self(
            "Unable to read configuration directory: {$directory}"
        );
    }

    /**
     * @brief Create an exception for an invalid configuration file.
     */
    public static function invalidFile(string $file): self
    {
        return new self(
            "Configuration file must return an array: {$file}"
        );
    }
}
