# FyreConfig

**FyreConfig** is a free, configuration library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Methods](#methods)



## Installation

**Using Composer**

```
composer require fyre/config
```

In PHP:

```php
use Fyre\Config\Config;
```


## Methods

**Add Path**

Add a config path.

- `$path` is the path to add.
- `$prepend` is a boolean indicating whether to prepend the file path, and will default to *false*.

```php
Config::addPath($path, $prepend);
```

**Clear**

Clear config data.

```php
Config::clear();
```

**Clear Paths**

Clear the paths.

```php
Config::clearPaths();
```

**Consume**

Retrieve and delete a value from the config using "dot" notation.

- `$key` is the key to lookup.
- `$default` is the default value to return, and will default to *null*.

```php
$value = Config::consume($key, $default);
```

**Delete**

Delete a value from the config using "dot" notation.

- `$key` is the key to remove.

```php
$deleted = Config::delete($key);
```

**Get**

Retrieve a value from the config using "dot" notation.

- `$key` is the key to lookup.
- `$default` is the default value to return, and will default to *null*.

```php
$value = Config::get($key, $default);
```

**Get Paths**

Get the paths.

```php
$paths = Config::getPaths();
```

**Has**

Determine if a value exists in the config.

- `$key` is the key to check for.

```php
$has = Config::has($key);
```

**Load**

Load a file into the config.

- `$file` is a string representing the config file.

```php
Config::load($file);
```

**Remove Path**

Remove a path.

- `$path` is the path to remove.

```php
$removed = Config::removePath($path);
```

**Set**

Set a config value using "dot" notation.

- `$key` is the key.
- `$value` is the value to set.
- `$overwrite` is a boolean indicating whether previous values will be overwritten, and will default to *true*.

```php
Config::set($key, $value, $overwrite);
```