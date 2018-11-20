<?php

/**
 * Linna Framework.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types = 1);

namespace App\Helper;

use Linna\DotEnv\DotEnv;

/**
 * DotEnv.
 *
 * Load variables from a .env file to environment.
 */
class AppDotEnv extends DotEnv
{
    /**
     * @var array Keys to look for into .en file
     */
    private static $envKeys = [
        'session.name',
        'session.expire',
        'pdo_mysql.user',
        'pdo_mysql.password',
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
     * Merge .env values into $config variable.
     *
     * @param array $keys
     * @param array $config
     */
    private function envToConfig(array $keys, array &$config): void
    {
        $array = [];

        foreach ($keys as $key) {
            $value = getenv($key);

            if ($value !== false) {
                $names = explode('.', $key);
                $count = count($names);

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

        $config = array_merge($array, $config);
    }
}
