<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Mappers;

use Linna\Auth\Password;
use Linna\Auth\User;
use Linna\Auth\UserMapperInterface;
use Linna\DataMapper\DomainObjectAbstract;
use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\MapperAbstract;
use Linna\DataMapper\NullDomainObject;
use Linna\Storage\MysqlPdoAdapter;

/**
 * UserMapper.
 */
class UserMapper extends MapperAbstract implements UserMapperInterface
{
    /**
     * @var Password Password util for user object
     */
    protected $password;

    /**
     * @var \PDO Database Connection
     */
    protected $dBase;

    /**
     * Constructor.
     *
     * @param \PDO     $dBase
     * @param Password $password
     */
    public function __construct(MysqlPdoAdapter $dBase, Password $password)
    {
        $this->dBase = $dBase->getResource();
        $this->password = $password;
    }

    /**
     * Fetch a user object by id.
     *
     * @param string $userId
     *
     * @return DomainObjectAbstract
     */
    public function fetchById(int $userId) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, email, description, password, active, created, last_update AS lastUpdate FROM user WHERE user_id = :id');

        $pdos->bindParam(':id', $userId, \PDO::PARAM_INT);
        $pdos->execute();

        $result = $pdos->fetchObject('\Linna\Auth\User', [$this->password]);

        return ($result instanceof User) ? $result : new NullDomainObject();
    }

    /**
     * Fetch a user object by name.
     *
     * @param string $userName
     *
     * @return DomainObjectAbstract
     */
    public function fetchByName(string $userName) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, email, description, password, active, created, last_update AS lastUpdate FROM user WHERE md5(name) = :name');

        $hashedUserName = md5($userName);

        $pdos->bindParam(':name', $hashedUserName, \PDO::PARAM_STR);
        $pdos->execute();

        $result = $pdos->fetchObject('\Linna\Auth\User', [$this->password]);

        return ($result instanceof User) ? $result : new NullDomainObject();
    }

    /**
     * Fetch all users stored in data base.
     *
     * @return array All users stored
     */
    public function fetchAll() : array
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, email, description, password, active, created, last_update AS lastUpdate FROM user ORDER BY name ASC');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\User', [$this->password]);
    }

    /**
     * Fetch users with limit.
     *
     * @param int $offset
     * @param int $rowCount
     *
     * @return array
     */
    public function fetchLimit(int $offset, int $rowCount) : array
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, email, description, password, active, created, last_update AS lastUpdate FROM user ORDER BY name ASC LIMIT :offset, :rowcount');

        $pdos->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $pdos->bindParam(':rowcount', $rowCount, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\User', [$this->password]);
    }

    /**
     * Create a new User DomainObject.
     *
     * @return User
     */
    protected function concreteCreate() : DomainObjectInterface
    {
        return new User($this->password);
    }

    /**
     * Insert the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $user
     *
     * @throws \InvalidArgumentException
     *
     * @return int Last insert id
     */
    protected function concreteInsert(DomainObjectInterface $user) : int
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('INSERT INTO user (name, email, description, password, created) VALUES (:name, :email, :description, :password, NOW())');

            $pdos->bindParam(':name', $user->name, \PDO::PARAM_STR);
            $pdos->bindParam(':email', $user->email, \PDO::PARAM_STR);
            $pdos->bindParam(':description', $user->description, \PDO::PARAM_STR);
            $pdos->bindParam(':password', $user->password, \PDO::PARAM_STR);
            $pdos->execute();

            return (int) $this->dBase->lastInsertId();
        } catch (\RuntimeException $e) {
            echo 'Mapper: Insert not compled, ', $e->getMessage(), "\n";
        }
    }

    /**
     * Update the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $user
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteUpdate(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
        }

        try {
            $pdos = $this->dBase->prepare('UPDATE user SET name = :name, email = :email, description = :description,  password = :password, active = :active WHERE user_id = :user_id');

            $objId = $user->getId();

            $pdos->bindParam(':user_id', $objId, \PDO::PARAM_INT);

            $pdos->bindParam(':name', $user->name, \PDO::PARAM_STR);
            $pdos->bindParam(':email', $user->email, \PDO::PARAM_STR);
            $pdos->bindParam(':password', $user->password, \PDO::PARAM_STR);
            $pdos->bindParam(':description', $user->description, \PDO::PARAM_STR);
            $pdos->bindParam(':active', $user->active, \PDO::PARAM_INT);

            $pdos->execute();
        } catch (\Exception $e) {
            echo 'Mapper exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * Delete the DomainObject from persistent storage.
     *
     * @param DomainObjectAbstract $user
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteDelete(DomainObjectInterface $user)
    {
        if (!($user instanceof User)) {
            throw new \InvalidArgumentException('$user must be instance of User class');
        }

        try {
            $objId = $user->getId();
            $pdos = $this->dBase->prepare('DELETE FROM user WHERE user_id = :user_id');
            $pdos->bindParam(':user_id', $objId, \PDO::PARAM_INT);
            $pdos->execute();
        } catch (\Exception $e) {
            echo 'Mapper exception: ', $e->getMessage(), "\n";
        }
    }
}
