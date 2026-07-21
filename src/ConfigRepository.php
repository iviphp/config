<?php

declare(strict_types=1);

/**
 *
 * @file ConfigRepository.php
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

use Ivi\Support\Arr;

/**
 * @class ConfigRepository
 *
 * @brief Stores and manages application configuration values.
 *
 * The repository provides predictable access to configuration values
 * using simple keys or nested dot notation.
 *
 * @since 0.1.0
 */
final class ConfigRepository
{
    /**
     * @param array<string, mixed> $items Initial configuration values.
     */
    public function __construct(
        private array $items = []
    ) {}

    /**
     * @brief Retrieve a configuration value.
     *
     * @param string|null $key Configuration key using dot notation.
     * @param mixed $default Value returned when the key does not exist.
     *
     * @return mixed The resolved configuration value.
     */
    public function get(?string $key = null, mixed $default = null): mixed
    {
        return Arr::get($this->items, $key, $default);
    }

    /**
     * @brief Determine whether a configuration key exists.
     *
     * @param string $key Configuration key using dot notation.
     *
     * @return bool True when the key exists.
     */
    public function has(string $key): bool
    {
        return Arr::has($this->items, $key);
    }

    /**
     * @brief Store a configuration value.
     *
     * @param string $key Configuration key using dot notation.
     * @param mixed $value Value to store.
     *
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        Arr::set($this->items, $key, $value);
    }

    /**
     * @brief Remove a configuration value.
     *
     * @param string $key Configuration key using dot notation.
     *
     * @return void
     */
    public function forget(string $key): void
    {
        Arr::forget($this->items, $key);
    }

    /**
     * @brief Merge configuration values into the repository.
     *
     * Existing nested values are replaced recursively.
     *
     * @param array<string, mixed> $items Configuration values to merge.
     *
     * @return void
     */
    public function merge(array $items): void
    {
        $this->items = array_replace_recursive($this->items, $items);
    }

    /**
     * @brief Replace all configuration values.
     *
     * @param array<string, mixed> $items New configuration values.
     *
     * @return void
     */
    public function replace(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @brief Return all configuration values.
     *
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->items;
    }
}
