<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

use Linna\Storage\StorageFactory;
use Linna\Storage\ExtendedPDO;

//pdo with Mysql
$storage = (new StorageFactory('pdo', $config['pdo_mysql']))->get();
//store for dependency injection
$container->set(ExtendedPDO::class, $storage);
