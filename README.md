# SaintNestor version 2

**SaintNestor** is a simple logging module for your PHP projects.

![](https://img.shields.io/badge/PHP-7%2B-yellow) ![](https://img.shields.io/badge/version-2.0-blue)

## Install

1. Download and unpack **SaintNestor 2** last release into your project.
2. Hook up the **autoload.php** file:
```php
use SaintNestor\Logger;
// If you unpacked the SaintNestor to root directory of your application (site):
require_once __DIR__.'/SaintNestor/autoload.php';
```

## How to use

1. Create an object:
```php
// Write the fragments of the logs directory path as array elements.
// If you'll write 'DIR' instead of __DIR__, than SaintNestor understand it as it's own directory.
$logger = new Logger([__DIR__, 'logs']);
// You can specify custom filename and file extension using second and thind arguments.
// Also, you can split the log by the logging levels by fourth argument.
$logger = new Logger(['DIR', 'logs'], 'log'.date("Y-m-d"), '.txt', true);
```
2. Use the methods described in [PSR-3](https://www.php-fig.org/psr/psr-3/#3-psrlogloggerinterface "PSR-3"). For example:
```php
$message = 'User {username} signed in {date}.';
$context = ['username' => 'Boris', 'date' => date("d.m.Y")];
$logger->info($message, $context);
// Similar entry:
$logger->log(1, $message, $context);
```