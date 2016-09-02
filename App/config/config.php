<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2016, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */


/**
 * Configuration for: URL
 * Here we auto-detect your applications URL and the potential sub-folder. Works perfectly on most servers and in local
 * development environments (like WAMP, MAMP, etc.). Don't touch this unless you know what you do.
 */

/**
 * URL_PUBLIC_FOLDER:
 * The folder that is visible to public, users will only have access to that folder so nobody can have a look into
 * "/src" or other folder inside your application or call any other .php file than index.php inside "/public".
 */
define('URL_PUBLIC_FOLDER', 'public');
/*
 * URL_PROTOCOL:
 * The protocol. Don't change unless you know exactly what you do.
 */
define('URL_PROTOCOL', 'https://');
/*
 * URL_DOMAIN:
 * The domain. Don't change unless you know exactly what you do.
*/
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
/*
 * URL_SUB_FOLDER:
 * The sub-folder. Leave it like it is, even if you don't use a sub-folder (then this will be just "/").
 */
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
/*
 * URL:
 * The final, auto-detected URL (build via the segments above). If you don't want to use auto-detection,
 * then replace this line with full URL (and sub-folder) and a trailing slash.
 */
define('URL', URL_PROTOCOL.URL_DOMAIN.URL_SUB_FOLDER);

define('APP_NAMESPACE', 'app');

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
define('DB_PASS', 'cagiva');

/*
 * DB_CHARSET:
 * Database charset
 */
define('DB_CHARSET', 'utf8mb4');
