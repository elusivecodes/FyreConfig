<?php
declare(strict_types=1);

namespace Fyre\Config;

use Fyre\Utility\Arr;
use Fyre\Utility\Path;

use function array_replace_recursive;
use function array_splice;
use function array_unshift;
use function file_exists;
use function in_array;
use function is_array;

/**
 * Config
 */
abstract class Config
{

    protected static array $paths = [];

    protected static array $config = [];

    /**
     * Add a config path.
     * @param string $path The path to add.
     * @param bool $prepend Whether to prepend the path.
     */
    public static function addPath(string $path, bool $prepend = false): void
    {
        $path = Path::resolve($path);

        if (in_array($path, static::$paths)) {
            return;
        }

        if ($prepend) {
            array_unshift(static::$paths, $path);
        } else {
            static::$paths[] = $path;
        }
    }

    /**
     * Clear config data.
     */
    public static function clear(): void
    {
        static::$paths = [];
        static::$config = [];
    }

    /**
     * Retrieve and delete a value from the config using "dot" notation.
     * @param string $key The config key.
     * @param mixed $default The default value.
     * @return mixed The value.
     */
    public static function consume(string $key, $default = null): mixed
    {
        $value = static::get($key, $default);

        static::delete($key);

        return $value;
    }

    /**
     * Delete a value from the config using "dot" notation.
     * @param string $key The config key.
     * @return bool TRUE if the key was deleted, otherwise FALSE.
     */
    public static function delete(string $key): bool
    {
        if (!Arr::hasDot(static::$config, $key)) {
            return false;
        }

        static::$config = Arr::forgetDot(static::$config, $key);

        return true;
    }

    /**
     * Retrieve a value from the config using "dot" notation.
     * @param string $key The config key.
     * @param mixed $default The default value.
     * @return mixed The config value.
     */
    public static function get(string $key, $default = null): mixed
    {
        return Arr::getDot(static::$config, $key, $default);
    }

    /**
     * Get the paths.
     * @return array The paths.
     */
    public static function getPaths(): array
    {
        return static::$paths;
    }

    /**
     * Determine if a value exists in the config.
     * @param string $key The config key.
     * @return bool TRUE if the item exists, otherwise FALSE.
     */
    public static function has(string $key): bool
    {
        return Arr::hasDot(static::$config, $key);
    }

    /**
     * Load a file into the config.
     * @param string $file
     */
    public static function load(string $file): void
    {
        $file .= '.php';

        foreach (static::$paths AS $path) {
            $filePath = Path::join($path, $file);

            if (!file_exists($filePath)) {
                continue;
            }

            $config = require $filePath;

            if (!is_array($config)) {
                continue;
            }

            static::$config = array_replace_recursive(static::$config, $config);
        }
    }

    /**
     * Remove a path.
     * @param string $path The path to remove.
     * @return bool TRUE if the path was removed, otherwise FALSE.
     */
    public static function removePath(string $path): bool
    {
        $path = Path::resolve($path);

        foreach (static::$paths AS $i => $otherPath) {
            if ($otherPath !== $path) {
                continue;
            }

            array_splice(static::$paths, $i, 1);

            return true;
        }

        return false;
    }

    /**
     * Set a config value using "dot" notation.
     * @param string $key The config key.
     * @param mixed $value The config value.
     * @param bool $overwrite Whether to overwrite previous values.
     */
    public static function set(string $key, $value, bool $overwrite = true): void
    {
        static::$config = Arr::setDot(static::$config, $key, $value, $overwrite);
    }

}
