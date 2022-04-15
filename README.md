# Logging

Simple wordpress log support

## Standard logging

Set a log level in your wp-config.php

```
define('WP_DEBUG_LOG_LEVEL', 'debug');

define('WP_DEBUG', 'true');
```

Levels are:

- debug
- info
- error

Call from the code base

```
Log::debug('');
```

```
Log::info('');
```

```
Log::error('');
```

## Timings

At the beginning of a collection of operations

```
Log::start('Search');
```

At the end of a collection of operations

```
Log::finish('Search');
```

> Note the attribute in `start` and `finish` should match
