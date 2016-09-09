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

namespace App\Mappers;

use Linna\Database\DomainObjectInterface;
use Linna\Database\MapperAbstract;
use Linna\Database\Database;
use App\DomainObjects\User;

/**
 * UserMapper
 *
 */
class UserMapper extends MapperAbstract
{

    /**
     * @var object Database Connection
     */
    protected $dBase;

    /**
     * Constructor
     *
     * Open only a database connection
     */
    public function __construct(Database $dBase)
    {
        $this->dBase = $dBase;
    }

    /**
     * Fetch a user object by id
     *
     * @param string $userId
     *
     * @return User
     */
    public function findById($userId)
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS _Id, name, description, password, active, created, last_update FROM user WHERE user_id = :id');

        $pdos->bindParam(':id', $userId, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\User');
    }

    /**
     * Fetch a user object by name
     *
     * @param string $userName
     *
     * @return User
     */
    public function findByName($userName)
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS _Id, name, description, password, active, created, last_update FROM user WHERE md5(name) = :name');

        $hashedUserName = md5($userName);

        $pdos->bindParam(':name', $hashedUserName, \PDO::PARAM_STR);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\User');
    }

    /**
     * Fetch all users stored in data base
     *
     * @return array All users stored
     */
    public function getAllUsers()
    {
        $pdos = $this->dBase->prepare('SELECT user_id as _Id, name, description, password, active, created, last_update FROM user ORDER BY name ASC');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\User');
    }

    /**
     * Create a new User DomainObject
     *
     * @return User
     */
    protected function _Create()
    {
        return new User();
    }

    /**
     * Insert the DomainObject in persistent storage
     *
     * @param DomainObjectInterface $user
     */
    protected function _Insert(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \Exception('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('INSERT INTO user (name, description, password, created) VALUES (:name, :description, :password, NOW())');

            $pdos->bindParam(':name', $user->name, \PDO::PARAM_STR);
            $pdos->bindParam(':description', $user->description, \PDO::PARAM_STR);
            $pdos->bindParam(':password', $user->password, \PDO::PARAM_STR);
            $pdos->execute();

            return $this->dBase->lastInsertId();
        } catch (\Exception $e) {
            echo 'Mapper exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * Update the DomainObject in persistent storage
     *
     * @param DomainObjectInterface $user
     */
    protected function _Update(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \Exception('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('UPDATE user SET name = :name, description = :description,  password = :password, active = :active WHERE user_id = :user_id');

            $objId = $user->getId();

            $pdos->bindParam(':user_id', $objId, \PDO::PARAM_INT);

            $pdos->bindParam(':name', $user->name, \PDO::PARAM_STR);
            $pdos->bindParam(':password', $user->password, \PDO::PARAM_STR);
            $pdos->bindParam(':description', $user->description, \PDO::PARAM_STR);
            $pdos->bindParam(':active', $user->active, \PDO::PARAM_INT);

            $pdos->execute();
        } catch (\Exception $e) {
            echo 'Mapper exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * Delete the DomainObject from persistent storage
     *
     * @param DomainObjectAbstract $user
     */
    protected function _Delete(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \Exception('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('DELETE FROM user WHERE user_id = :user_id');
            $pdos->bindParam(':user_id', $user->getId(), \PDO::PARAM_INT);
            $pdos->execute();
        } catch (\Exception $e) {
            echo 'Mapper exception: ', $e->getMessage(), "\n";
        }
    }
}
