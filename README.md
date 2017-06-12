![Linna App](logo-app.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/linna/app.svg?branch=master)](https://travis-ci.org/linna/app)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/linna/app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/linna/app/?branch=master)
[![StyleCI](https://styleci.io/repos/41215510/shield?branch=master&style=flat)](https://styleci.io/repos/41215510)

App Skeleton for Linna framework

## Getting Started

### Requirements
App was written for run with linna-framework and need PHP 7.0 or higher, was tested under Linux with Apache (mod rewrite on) web server with default php.ini.  

### Installation
*Consider use of sudo command if need administrator privileges and don't forget to set proper folder permissions*

With [composer](https://getcomposer.org/)
```
cd /var/www/html
mkdir app
composer create-project --prefer-dist s3b4stian/linna-app app
```
Where "app" is directory under webserver document root ex. /var/www/html/app

After, run composer [dump-autoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
```
composer dump-autoload --optimize
```

### Before run
Change config in config.php file placed in /var/www/html/app/config directory.

#### Protocol and app dir
```php
$options = [

    'app' => [
        'urlProtocol'     => 'http://',
        'urlSubFolder'    => '/app', // es /var/www/html/app/
        'urlPublicFolder' => '/app/public', // es /var/www/html/app/public
    ],
    //other options
];
```

#### Rewrite engine
```php
$options = [
    //other options
    'router' => [
        'basePath'    => '/app', //equal to urlSubFolder
        'badRoute'    => 'E404',
        'rewriteMode' => true,
    ],
    //other options
];
```

Now App can be started from browser
