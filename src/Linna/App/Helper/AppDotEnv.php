<?php

/**
 * Linna Framework.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Helper;

use Linna\DotEnv\DotEnv;

/**
 * DotEnv.
 *
 * Load variables from a .env file to environment.
 */
class AppDotEnv extends DotEnv
{
    /** @var array Keys to look for into .en file */
    private static $envKeys = [
        'session.name',
        'session.expire',
        'pdo_mysql.dsn',
        'pdo_mysql.user',
        'pdo_mysql.password',
        'pdo_pgsql.dsn',
        'pdo_pgsql.user',
        'pdo_pgsql.password',
        'mysqli.host',
        'mysqli.user',
        'mysqli.password',
        'mysqli.database',
        'mysqli.port',
        'mongo_db.uri',
        'memcached.host',
        'memcached.port'
    ];

    /**
     * Load environment variables from file and override $config values.
     *
     * @param string $file   Path to .env file
     * @param array  $config App config file
     */
    public function override(string $file, array &$config): void
    {
        parent::load($file);

        $this->envToConfig(self::$envKeys, $config);
    }

    /**
     * Register a new valid key for .env config file.
     *
     * @param string $key
     */
    public function registerKey(string $key)
    {
        \array_push(self::$envKeys, $key);
    }

    /**
     * Register a new set of valid keys for .env config file.
     *
     * @param array $keys
     */
    public function registerKeys(array $keys)
    {
        foreach ($keys as $key) {
            \array_push(self::$envKeys, $key);
        }
    }

    /**
     * Merge .env values into $config variable.
     *
     * @param array $keys
     * @param array $config
     */
    private function envToConfig(array $keys, array &$config): void
    {
        $array = [];

        foreach ($keys as $key) {
            $value = \getenv($key);

            if ($value !== false) {
                $names = \explode('.', $key);
                $count = \count($names);

                if ($count === 1) {
                    $array[$names[0]] = $value;
                }

                if ($count === 2) {
                    $array[$names[0]][$names[1]] = $value;
                }

                if ($count === 3) {
                    $array[$names[0]][$names[1]][$names[2]] = $value;
                }

                if ($count === 4) {
                    $array[$names[0]][$names[1]][$names[2]][$names[3]] = $value;
                }
            }
        }

        $config = \array_replace_recursive($config, $array);
    }
}
