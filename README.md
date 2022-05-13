<div align="center">
    <a href="#"><img src="logo-linna-96.png" alt="Linna Logo"></a>
</div>

<br/>

<div align="center">
    <a href="#"><img src="logo-app.png" alt="Linna dotenv Logo"></a>
</div>

<br/>

<div align="center">

[![Build Status](https://travis-ci.org/linna/app.svg?branch=master)](https://travis-ci.org/linna/app)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/linna/app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/linna/app/?branch=master)
[![StyleCI](https://styleci.io/repos/41215510/shield?branch=master&style=flat)](https://styleci.io/repos/41215510)
[![PDS Skeleton](https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat)](https://github.com/php-pds/skeleton)
[![PHP 8.1](https://img.shields.io/badge/PHP-7.4-8892BF.svg)](http://php.net)

</div>

# About
Application Skeleton for Linna framework

# Index
1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Before first run](#before-first-run)
    * [Protocol and app dir config](#protocol-and-app-dir-config)
    * [Router config](#router-config)
4. [Url rewriting](#url-rewriting)
    * [Apache Virtual Host config for mod_rewrite](#apache-virtual-host-config-for-mod_rewrite)
    * [Apache .htaccess config for mod_rewrite](#apache-htaccess-config-for-mod_rewrite)
    * [Nginx](#nginx)
5. [Dot env file](#dot-env-file)

# Requirements
* App need [linna/framework](https://github.com/linna/framework), please read the
[changelog](https://github.com/linna/app/blob/b0.16.0/CHANGELOG.md) for know with 
which version the app works.
* PHP 7.4 or higher.

> **Note:** App was only tested under Linux with Apache web server with default php.ini

# Installation
> **Note:** Consider use of sudo command if need administrator privileges and don't
forget to set proper folder permissions

With [composer](https://getcomposer.org/)
```Shell
cd /var/www/html
mkdir app
composer create-project --prefer-dist linna/app app
```
Where `app` is directory under webserver document root ex. `/var/www/html/app`

After, run composer [dump-autoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
```Shell
composer dump-autoload --optimize
```

# Before first run
Change config in `config.php` file placed in `/var/www/html/app/config` directory.

## Protocol and app dir config
```php
$options = [

    'app' => [
        //protocol utilized [http://, https://]
        //default value set automatically
        'protocol'     => REQUEST_SCHEME.'://',
        //folder of the app, if app isn't in the web server root add a
        //directory (/app, /other/app) else insert a / (slash) as value
        //default value [/app]
        'subFolder'    => '/app',
        //public folder of the app, starting from web server root
        //default value [/app/public]
        'publicFolder' => '/app/public',
        //.env file position, remember to add ../ if don't use an absolute path
        'envFile'      => '../.env',
        //name of the fallback route, indicate the path when router return a NullRoute
        //default /error/404
        'onNullRoute'  => '/error/404'
    ],

    //other options
];
```

## Router config
```php
$options = [

    //other options

    'router' => [
        //must be equal to app.subFolder, it represents the part of the path
        //that the router ignore when check a route. Example '/app/user/delete/5'
        //become '/user/delete/5' where the router subtract the basePath
        //default [/app]
        'basePath'             => '/app',
        //url rewriting
        //default [true]
        'rewriteMode'          => true,
        //part of the url that the router ignore when url rewriting is off
        'rewriteModeOffRouter' => '/index.php?',
    ],

    //other options
];
```

# Url rewriting
If you enable the option of the router named `rewriteMode` in `config.php`,
need to configure your virtual host/server block.

## Apache Virtual Host config for mod_rewrite
For Apache VirtualHost config please see:  
[http://httpd.apache.org/docs/current/vhosts/](http://httpd.apache.org/docs/current/vhosts/)  
For Apache mod_rewrite config please see:  
[https://httpd.apache.org/docs/current/rewrite/](https://httpd.apache.org/docs/current/rewrite/)  
```ApacheConf
<VirtualHost *:80>

    # Other virtual host directives.

    <Directory /var/www/html/app>
        RewriteEngine on
        # Route to /app/public
        RewriteRule ^(.*)  public/$1 [L]
    </Directory>

    <Directory /var/www/html/app/public>
        # Necessary to prevent problems when using a controller named "index" and having a root index.php
        # more here: http://httpd.apache.org/docs/current/content-negotiation.html
        Options -MultiViews

        # Activates URL rewriting (like myproject.com/controller/action/1/2/3)
        RewriteEngine On

        # Prevent people from looking directly into folders
        Options -Indexes

        # If the following conditions are true, then rewrite the URL:
        # If the requested filename is not a directory,
        RewriteCond %{REQUEST_FILENAME} !-d
        # and if the requested filename is not a regular file that exists,
        RewriteCond %{REQUEST_FILENAME} !-f
        # and if the requested filename is not a symbolic link,
        RewriteCond %{REQUEST_FILENAME} !-l

        # then rewrite the URL in the following way:
        # Take the whole request filename and provide it as the value of a
        # "url" query parameter to index.php. Append any query string from
        # the original URL as further query parameters (QSA), and stop
        # processing (L).
        # https://httpd.apache.org/docs/current/rewrite/flags.html#flag_qsa
        # https://httpd.apache.org/docs/current/rewrite/flags.html#flag_l
        RewriteRule ^(.+)$ index.php [QSA,L]
    </Directory>

    # Other virtual host directives.

</VirtualHost>
```

## Apache .htaccess config for mod_rewrite
If you haven't access to your apache virtual host configuration,
you can add .htaccess files to the app for enable mod_rewrite.  

Create `.htaccess` file in `app/` directory with this content:
```ApacheConf
RewriteEngine on
# Route to /app/public
RewriteRule ^(.*)  public/$1 [L]
```

Create `.htaccess` file in `app/public/` directory with this content:
```ApacheConf
# Necessary to prevent problems when using a controller named "index" and having a root index.php
# more here: http://httpd.apache.org/docs/current/content-negotiation.html
Options -MultiViews

# Activates URL rewriting (like myproject.com/controller/action/1/2/3)
RewriteEngine On

# Prevent people from looking directly into folders
Options -Indexes

# If the following conditions are true, then rewrite the URL:
# If the requested filename is not a directory,
RewriteCond %{REQUEST_FILENAME} !-d
# and if the requested filename is not a regular file that exists,
RewriteCond %{REQUEST_FILENAME} !-f
# and if the requested filename is not a symbolic link,
RewriteCond %{REQUEST_FILENAME} !-l

# then rewrite the URL in the following way:
# Take the whole request filename and provide it as the value of a
# "url" query parameter to index.php. Append any query string from
# the original URL as further query parameters (QSA), and stop
# processing (L).
# https://httpd.apache.org/docs/current/rewrite/flags.html#flag_qsa
# https://httpd.apache.org/docs/current/rewrite/flags.html#flag_l
RewriteRule ^(.+)$ index.php [QSA,L]
```

## Nginx 
For Nginx Server Blocks config please see:  
[https://www.nginx.com/resources/wiki/start/topics/examples/server_blocks/](https://www.nginx.com/resources/wiki/start/topics/examples/server_blocks/)  

Setting url rewrite with Nginx is simpler than Apache counterpart, 
add `try_files $uri $uri/ /index.php?$args;` to `location` block:
```Nginx
server {

    # Other directives
    
    location / {
        # Url rewrite
        # Add line blow to location block for enable url rewriting
        try_files $uri $uri/ /index.php?$args;
    }

    # Other directives
}
```

# Dot env file
With `composer` installation, a `.env` file is created into `app` root directory 
and it could be used for declaring default environment variables.

`.env` file content look like this:
```
# Session
session.name   = linna_session
session.expire = 1800

## Pdo Mysql
pdo_mysql.user     = root
pdo_mysql.password =

## Mysqli
#mysqli.host     = 127.0.0.1
#mysqli.user     = root
#mysqli.password =
#mysqli.database = linna_db
#mysqli.port     = 3306

## MongoDB
#mongo_db.uri = mongodb://localhost:27017

## Memcached
#memcached.host = localhost
#memcached.port = 11211
```

`.env` file valid keys:
```
session.name
session.expire

pdo_mysql.dsn
pdo_mysql.user
pdo_mysql.password

pdo_pgsql.dsn
pdo_pgsql.user
pdo_pgsql.password

mysqli.host
mysqli.user
mysqli.password
mysqli.database
mysqli.port

mongo_db.uri

memcached.host
memcached.port
```

Values declared in the file will overwrite `config.php` values.

Position of `.env` file could be changed editing `envFile` value.
```php
$options = [

    'app' => [
        //other app options
        'envFile'           => '../.env'
    ],

    //other options
];
```

If you do not want use `.env` file can delete it.
