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
class Config
{
    protected array $config = [];

    protected array $paths = [];

    /**
     * Add a config path.
     *
     * @param string $path The path to add.
     * @param bool $prepend Whether to prepend the path.
     * @return static The Config.
     */
    public function addPath(string $path, bool $prepend = false): static
    {
        $path = Path::resolve($path);

        if (!in_array($path, $this->paths)) {
            if ($prepend) {
                array_unshift($this->paths, $path);
            } else {
                $this->paths[] = $path;
            }
        }

        return $this;
    }

    /**
     * Clear config data.
     */
    public function clear(): void
    {
        $this->paths = [];
        $this->config = [];
    }

    /**
     * Retrieve and delete a value from the config using "dot" notation.
     *
     * @param string $key The config key.
     * @param mixed $default The default value.
     * @return mixed The value.
     */
    public function consume(string $key, $default = null): mixed
    {
        $value = $this->get($key, $default);

        $this->delete($key);

        return $value;
    }

    /**
     * Delete a value from the config using "dot" notation.
     *
     * @param string $key The config key.
     * @return static The Config.
     */
    public function delete(string $key): static
    {
        $this->config = Arr::forgetDot($this->config, $key);

        return $this;
    }

    /**
     * Retrieve a value from the config using "dot" notation.
     *
     * @param string $key The config key.
     * @param mixed $default The default value.
     * @return mixed The config value.
     */
    public function get(string $key, $default = null): mixed
    {
        return Arr::getDot($this->config, $key, $default);
    }

    /**
     * Get the paths.
     *
     * @return array The paths.
     */
    public function getPaths(): array
    {
        return $this->paths;
    }

    /**
     * Determine if a value exists in the config.
     *
     * @param string $key The config key.
     * @return bool TRUE if the item exists, otherwise FALSE.
     */
    public function has(string $key): bool
    {
        return Arr::hasDot($this->config, $key);
    }

    /**
     * Load a file into the config.
     *
     * @return static The Config.
     */
    public function load(string $file): static
    {
        $file .= '.php';

        foreach ($this->paths as $path) {
            $filePath = Path::join($path, $file);

            if (!file_exists($filePath)) {
                continue;
            }

            $config = require $filePath;

            if (!is_array($config)) {
                continue;
            }

            $this->config = array_replace_recursive($this->config, $config);
        }

        return $this;
    }

    /**
     * Remove a path.
     *
     * @param string $path The path to remove.
     * @return static The Config.
     */
    public function removePath(string $path): static
    {
        $path = Path::resolve($path);

        foreach ($this->paths as $i => $otherPath) {
            if ($otherPath !== $path) {
                continue;
            }

            array_splice($this->paths, $i, 1);
            break;
        }

        return $this;
    }

    /**
     * Set a config value using "dot" notation.
     *
     * @param string $key The config key.
     * @param mixed $value The config value.
     * @param bool $overwrite Whether to overwrite previous values.
     * @return static The Config.
     */
    public function set(string $key, $value, bool $overwrite = true): static
    {
        $this->config = Arr::setDot($this->config, $key, $value, $overwrite);

        return $this;
    }
}
