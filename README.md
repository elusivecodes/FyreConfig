# FyreConfig

**FyreConfig** is a free, open-source configuration library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Basic Usage](#basic-usage)
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


## Basic Usage

```php
$config = new Config();
```

**Autoloading**

It is recommended to bind the *Config* to the [*Container*](https://github.com/elusivecodes/FyreContainer) as a singleton.

```php
$container->singleton(Config::class);
```


## Methods

**Add Path**

Add a config path.

- `$path` is the path to add.
- `$prepend` is a boolean indicating whether to prepend the file path, and will default to *false*.

```php
$config->addPath($path, $prepend);
```

**Clear**

Clear config data.

```php
$config->clear();
```

**Consume**

Retrieve and delete a value from the config using "dot" notation.

- `$key` is the key to lookup.
- `$default` is the default value to return, and will default to *null*.

```php
$value = $config->consume($key, $default);
```

**Delete**

Delete a value from the config using "dot" notation.

- `$key` is the key to remove.

```php
$config->delete($key);
```

**Get**

Retrieve a value from the config using "dot" notation.

- `$key` is the key to lookup.
- `$default` is the default value to return, and will default to *null*.

```php
$value = $config->get($key, $default);
```

**Get Paths**

Get the paths.

```php
$paths = $config->getPaths();
```

**Has**

Determine if a value exists in the config.

- `$key` is the key to check for.

```php
$has = $config->has($key);
```

**Load**

Load a file into the config.

- `$file` is a string representing the config file.

```php
$config->load($file);
```

**Remove Path**

Remove a path.

- `$path` is the path to remove.

```php
$config->removePath($path);
```

**Set**

Set a config value using "dot" notation.

- `$key` is the key.
- `$value` is the value to set.
- `$overwrite` is a boolean indicating whether previous values will be overwritten, and will default to *true*.

```php
$config->set($key, $value, $overwrite);
```