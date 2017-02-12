<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

namespace App\Mappers;

use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\MapperAbstract;
use Linna\Storage\MysqlPdoAdapter;
use Linna\Auth\Password;
use App\DomainObjects\User;

/**
 * UserMapper
 *
 */
class UserMapper extends MapperAbstract
{
    /**
     * @var Password $password Password util for user object
     */
    protected $password;

    /**
     * @var \PDO $dBase Database Connection
     */
    protected $dBase;

    /**
     * Constructor
     *
     * @param \PDO $dBase
     * @param Password $password
     */
    public function __construct(MysqlPdoAdapter $dBase, Password $password)
    {
        $this->dBase = $dBase->getResource();
        $this->password = $password;
    }

    /**
     * Fetch a user object by id
     *
     * @param string $userId
     *
     * @return User | bool
     */
    public function findById(int $userId)
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, description, password, active, created, last_update AS lastUpdate FROM user WHERE user_id = :id');

        $pdos->bindParam(':id', $userId, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\User', array($this->password));
    }

    /**
     * Fetch a user object by name
     *
     * @param string $userName
     *
     * @return User | bool
     */
    public function findByName(string $userName)
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, description, password, active, created, last_update AS lastUpdate FROM user WHERE md5(name) = :name');

        $hashedUserName = md5($userName);

        $pdos->bindParam(':name', $hashedUserName, \PDO::PARAM_STR);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\User', array($this->password));
    }

    /**
     * Fetch all users stored in data base
     *
     * @return array All users stored
     */
    public function getAllUsers() : array
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, description, password, active, created, last_update AS lastUpdate FROM user ORDER BY name ASC');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\User', array($this->password));
    }

    /**
     * Create a new User DomainObject
     *
     * @return User
     */
    protected function oCreate() : User
    {
        return new User($this->password);
    }

    /**
     * Insert the DomainObject in persistent storage
     *
     * @param DomainObjectInterface $user
     * @return int Last insert id
     * @throws \InvalidArgumentException
     */
    protected function oInsert(DomainObjectInterface $user) : int
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('INSERT INTO user (name, description, password, created) VALUES (:name, :description, :password, NOW())');

            $pdos->bindParam(':name', $user->name, \PDO::PARAM_STR);
            $pdos->bindParam(':description', $user->description, \PDO::PARAM_STR);
            $pdos->bindParam(':password', $user->password, \PDO::PARAM_STR);
            $pdos->execute();

            return (int) $this->dBase->lastInsertId();
        } catch (\RuntimeException $e) {
            echo 'Mapper: Insert not compled, ', $e->getMessage(), "\n";
        }
    }

    /**
     * Update the DomainObject in persistent storage
     *
     * @param DomainObjectInterface $user
     * @throws \InvalidArgumentException
     */
    protected function oUpdate(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
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
     * @throws \InvalidArgumentException
     */
    protected function oDelete(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
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
