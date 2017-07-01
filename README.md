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
composer create-project --prefer-dist linna/app app
```
Where "app" is directory under webserver document root ex. /var/www/html/app

After, run composer [dump-acoutoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
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

#### Url Rewriting
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

### Apache Virtual Host config for mod rewrite
If you enable rewriteMode in config.php need to add to your virtual host configuration file
the following line of code.  

For Apache VirtualHost config please see:  
[http://httpd.apache.org/docs/current/vhosts/](http://httpd.apache.org/docs/current/vhosts/)  
For Apache mod_rewrite config please see:  
[https://httpd.apache.org/docs/current/rewrite/](https://httpd.apache.org/docs/current/rewrite/)  
```
<VirtualHost *:80>

    # Other virtual host directives.

    <Directory /var/www/html/app>
        RewriteEngine on
        # Route to /app/public
        RewriteRule ^(.*)  public/$1 [L]
    </Directory>

    <Directory /var/www/html/app/public>
        # Necessary to prevent problems when using a controller named "index" and having a root index.php
        # more here: http://httpd.apache.org/docs/2.2/content-negotiation.html
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

Now App can be started from browser
