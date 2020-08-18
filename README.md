# SaintNestor

**SaintNestor** is a simple logging module for your PHP projects.

## Install

1. Download and unpack **SaintNestor** last release into your project.
2. Hook up the **saint-nestor-load.php** file:
```php
require_once __DIR__.'\\saint-nestor-load.php';
```

## How to use

```php
/**
* $saint_nestor is an object of the SaintNestor class.
*/
/**
* SaintNestor::write_log() takes a message (string),
* a code (int) and a custom filename (string, optional argument).
*
* Logs will be saved into logs folder in the root directory of your project.
*/
$saint_nestor->write_log('logging test', 0);
/**
* You can change the path of the logs folder.
* Make sure this folder exists!
*/
$saint_nestor->logs_dir = __DIR__.'\\logs_new';
/**
* By default, the log filename is an actual UNIX-timestamp.
* You can change it by defining the filename format like in date().
*/
$saint_nestor->log_name_format = 'Y-m-d_H-i-s';
/**
* There is a three codes by default:
* 0 — NOTICE, 1 — WARNING, 2 — ERROR
*/
$saint_nestor->write_log('test notice', 0);
$saint_nestor->write_log('test warning', 1);
$saint_nestor->write_log('test error', 2);
/**
* Also, you can set a special name for message.
* The special name must be given with the file extension.
*/
$saint_nestor->write_log('test test', 2, 'test.log');
/**
* At last, you can change the logging level.
* If the message code is below logging level, this message will not be recorded.
* 
* By default, the logging level is 0.
*/
$saint_nestor->logging_level = 2;
$saint_nestor->write_log('logging level test', 2); // this message will be recorded
$saint_nestor->write_log('logging level test 2', 1); // and this will be not
```


## Settings

In the **saint-nestor-load.php** file you can change the logs folder at the initialization of a **SaintNestor** object. In this case, this folder will be created if it does not exist.
```php
$saint_nestor = new SaintNestor(__DIR__.'\\logstwo');
```
*Rigidity* is a property that determines whether to stop the application by the die() or not if the log file was not created/updated. By default, **SaintNestor::rigidity** is true. You can change it at the initialization of an object.
```php
$saint_nestor = new SaintNestor(__DIR__.'\\logs', false);
```
