<?php
declare(strict_types=1);

namespace Fyre\Config;

use
    Fyre\Utility\Arr,
    Fyre\Utility\Path;

use function
    array_replace_recursive,
    array_unshift,
    file_exists,
    is_array;

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

        if ($prepend) {
            array_unshift(static::$paths, $path);
        } else {
            static::$paths[] = $path;
        }
    }

    /**
     * Clear config data.
     */
    public static function clear()
    {
        static::$config = [];
        static::$paths = [];
    }

    /**
     * Retrieve and delete a value from the config using "dot" notation.
     * @param string $key The config key.
     * @param mixed $default The default value.
     * @return mixed The value.
     */
    public static function consume(string $key, $default = null)
    {
        $value = static::get($key, $default);

        static::delete($key);

        return $value;
    }

    /**
     * Delete a value from the config using "dot" notation.
     * @param string $key The config key.
     */
    public static function delete(string $key): void
    {
        static::$config = Arr::forgetDot(static::$config, $key);
    }

    /**
     * Retrieve a value from the config using "dot" notation.
     * @param string $key The config key.
     * @return mixed The config value.
     */
    public static function get(string $key, $default = null)
    {
        return Arr::getDot(static::$config, $key, $default);
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
     * Set a config value using "dot" notation.
     * @param string $key The config key.
     * @param mixed $value The config value.
     * @param bool $overwrite Whether to overwrite previous values.
     */
    public static function set(string $key, $value, $overwrite = true): void
    {
        static::$config = Arr::setDot(static::$config, $key, $value, $overwrite);
    }

}
