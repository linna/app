![Linna App](logo-app.png)
<br/>
<br/>
<br/>
[![Build Status](https://travis-ci.org/linna/app.svg?branch=master)](https://travis-ci.org/linna/app)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/linna/app/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/linna/app/?branch=master)
[![StyleCI](https://styleci.io/repos/41215510/shield?branch=master&style=flat)](https://styleci.io/repos/41215510)

Application Skeleton for Linna framework

## Getting Started

### Requirements
App was written for run with [linna/framework](https://github.com/linna/framework) 
and need PHP 7.0 or higher, was tested under Linux with Apache web server with default php.ini.  

### Installation
> **Note:** Consider use of sudo command if need administrator privileges and don't 
forget to set proper folder permissions

With [composer](https://getcomposer.org/)
```Shell
cd /var/www/html
mkdir app
composer create-project --prefer-dist linna/app app
```
Where app is directory under webserver document root ex. `/var/www/html/app`

After, run composer [dump-acoutoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) for optimize file autoloading
```Shell
composer dump-autoload --optimize
```

### Before run
Change config in `config.php` file placed in `/var/www/html/app/config` directory.

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

#### Apache Virtual Host config for mod_rewrite
If you enable the option of the router named `rewriteMode` in `config.php`, 
need to add to your virtual host configuration file the following line of code.  

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

#### .htaccess config for mod_rewrite
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

Now App can be started from browser.
