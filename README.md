![Linna App](logo-app.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/s3b4stian/linna-app.svg?branch=master)](https://travis-ci.org/s3b4stian/linna-app)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/s3b4stian/linna-app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/s3b4stian/linna-app/?branch=master)
[![Code Climate](https://codeclimate.com/github/s3b4stian/linna-app/badges/gpa.svg)](https://codeclimate.com/github/s3b4stian/linna-app)
[![StyleCI](https://styleci.io/repos/41215510/shield?branch=master&style=flat)](https://styleci.io/repos/41215510)

App Skeleton for Linna framework

## Getting Started

### Requirements
App was written for run with linna-framework and need PHP 7.0 or higher, 
was tested under Linux with Apache (mod rewrite on) web server with default php.ini.<br/>
Mysql (PDO Driver) is also needed for run because App contains login and user managment examples that require database.

App is also ready for use as storage Mongodb through [mongodb-php-library](https://github.com/mongodb/mongo-php-library).

Mongodb require [mongodb-php-driver](https://github.com/mongodb/mongo-php-driver) enabled.

[index.php](https://github.com/s3b4stian/linna-app/blob/master/public/index.php) in public folder contains commented code for start with Mongodb, uncomment it if you need.

### Installation
*Consider use of sudo command if need administrator privileges and don't forget to set proper folder permissions*

With [composer](https://getcomposer.org/)
```
cd /var/www/html
mkdir app
composer create-project --prefer-dist s3b4stian/linna-app app
```
Where "app" is directory under webserver document root ex. /var/www/html/app

If you need Mongodb
```
composer require mongodb/mongodb
```

After, run composer [dump-autoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
```
composer dump-autoload --optimize
```

### Before run
You must create App database, SQL file is placed in tests directory
```
cd /var/www/html/app
mysql -e 'create database linna_db;'
mysql -u root -p linna_db < tests/linna_db.sql
```
Change config in config.php file placed in /var/www/html/app/config directory.

#### Protocol and app dir
```php
$options = [

    'app' => [
        'urlProtocol' => 'http://',
        'urlSubFolder' => '/app/', // es /var/www/html/app/
        'urlPublicFolder' => 'public' // es /var/www/html/app/public
    ],
    //other options
];
```

#### Rewrite engine
```php
$options = [
    //other options
    'router' => [
        'basePath' => '/app/', //equal to urlSubFolder
        'badRoute' => 'E404',
        'rewriteMode' => true
    ],
    //other options
];
```

#### Database configuration
```php
$options = [
    //other options
    'pdo_mysql' => [
        'dsn' => 'mysql:host=localhost;dbname=test;charset=utf8mb4',
        'user' => 'root',
        'password' => 'password',
    ],
    //other options
];
```

Now App can be started from browser
