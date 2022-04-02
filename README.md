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

```php
Config::addPath($path, $prepend);
```

**Clear**

Clear config data.

```php
Config::clear();
```

**Consume**

Retrieve and delete a value from the config using "dot" notation.

```php
$value = Config::consume($key, $default);
```

**Delete**

Delete a value from the config using "dot" notation.

```php
Config::delete($key);
```

**Get**

Retrieve a value from the config using "dot" notation.

```php
$value = Config::get($key, $default);
```

**Has**

Determine if a value exists in the config.

```php
$has = Config::has($key);
```

**Load**

Load a file into the config.

```php
Config::load($file);
```

**Set**

Set a config value using "dot" notation.

```php
Config::set($key, $value, $overwrite);
```