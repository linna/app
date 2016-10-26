# Linna App
[![Build Status](https://travis-ci.org/s3b4stian/linna-app.svg?branch=master)](https://travis-ci.org/s3b4stian/linna-app)
[![Build Status](https://scrutinizer-ci.com/g/s3b4stian/linna-app/badges/build.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-app/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/s3b4stian/linna-app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-app/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/s3b4stian/linna-app/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-app/?branch=master)
[![Code Climate](https://codeclimate.com/github/s3b4stian/linna-app/badges/gpa.svg)](https://codeclimate.com/github/s3b4stian/linna-app)
[![Test Coverage](https://codeclimate.com/github/s3b4stian/linna-app/badges/coverage.svg)](https://codeclimate.com/github/s3b4stian/linna-app/coverage)
[![Issue Count](https://codeclimate.com/github/s3b4stian/linna-app/badges/issue_count.svg)](https://codeclimate.com/github/s3b4stian/linna-app)

App Skeleton for Linna framework

## Getting Started

### Requirements

App was written for run with linna-framework and need PHP 7.0 or higher, was tested under Linux with Apache (mod rewirte on) web server. Mysql is also needed for run because App contains login and user managment examples that require database.

App run with default php.ini.

### Installation

With [composer](https://getcomposer.org/)
```
cd /var/www/html
mkdir app
sudo composer create-project --prefer-dist s3b4stian/linna-app app
```
Where "app" is directory under webserver document root ex. /var/www/html/app

After, run composer [dump-autoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
```
sudo composer dump-autoload --optimize
```
#### Before run:
You must create App database, SQL file is placed in tests directory
```
cd /var/www/html/app
mysql -e 'create database test;'
mysql -u root -p test < tests/database.sql
```
Change config in config.php file placed in app/App/config directory.

Protocol
```php
define('URL_PROTOCOL', 'https://');
```
Rewrite engine
```php
//set this to false if is not possible to utilize rewrite engine of web server
define('REWRITE_ENGINE', true);
```
Database configuration
```php
/*
 * Configuration for: Database
 * This is the place where you define your database credentials, database type etc.
 */

/*
 * DB_TYPE:
 * Indicates the driver used from PDO
 */
define('DB_TYPE', 'mysql');

/*
 * DB_HOST:
 * Database host
 */
define('DB_HOST', 'localhost');

/*
 * DB_NAME:
 * Database name
 */
define('DB_NAME', 'test');

/*
 * DB_USER:
 * Database user
 */
define('DB_USER', 'root');

/*
 * DB_PASS:
 * Database password
 */
define('DB_PASS', 'password');

/*
 * DB_CHARSET:
 * Database charset
 */
define('DB_CHARSET', 'utf8mb4');
```

Now App can be started from browser
