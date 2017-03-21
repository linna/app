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

use Linna\Auth\PermissionMapperInterface;
use Linna\DataMapper\DomainObjectAbstract;
use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\MapperAbstract;
use Linna\DataMapper\NullDomainObject;
use Linna\Storage\MysqlPdoAdapter;

/**
 * PermissionMapper.
 */
class PermissionMapper extends MapperAbstract implements PermissionMapperInterface
{
    /**
     * @var \PDO Database Connection
     */
    protected $dBase;

    /**
     * Constructor.
     *
     * @param MysqlPdoAdapter $dBase
     */
    public function __construct(MysqlPdoAdapter $dBase)
    {
        $this->dBase = $dBase->getResource();
    }

    /**
     * Fetch a permission by id.
     *
     * @param int $permissionId
     *
     * @return DomainObjectInterface
     */
    public function fetchById(int $permissionId) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT permission_id AS objectId, name, description, last_update AS lastUpdate FROM permission WHERE permission_id = :id');

        $pdos->bindParam(':id', $permissionId, \PDO::PARAM_INT);
        $pdos->execute();

        $result = $pdos->fetchObject('\Linna\Auth\Permission');

        return ($result instanceof Permission) ? $result : new NullDomainObject();
    }

    /**
     * Fetch a permission by name.
     *
     * @param string $permissionName
     *
     * @return DomainObjectInterface
     */
    public function fetchByName(string $permissionName) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT permission_id AS objectId, name, description, last_update AS lastUpdate FROM permission WHERE name = :name');

        $pdos->bindParam(':name', $permissionName, \PDO::PARAM_STR);
        $pdos->execute();

        $result = $pdos->fetchObject('\Linna\Auth\Permission');

        return ($result instanceof Permission) ? $result : new NullDomainObject();
    }
    
    /**
     * Fetch all permission stored in data base.
     *
     * @return array
     */
    public function fetchAll() : array
    {
        $pdos = $this->dBase->prepare('SELECT permission_id AS objectId, name, description, last_update AS lastUpdate FROM permission');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Permission');
    }

    /**
     * Fetch permissions with limit.
     *
     * @param int $offset
     * @param int $rowCount
     *
     * @return array
     */
    public function fetchLimit(int $offset, int $rowCount) : array
    {
        $pdos = $this->dBase->prepare('SELECT permission_id AS objectId, name, description, last_update AS lastUpdate FROM permission LIMIT :offset, :rowcount');

        $pdos->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $pdos->bindParam(':rowcount', $rowCount, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Permission');
    }

    /**
     * Fetch Role's permissions.
     *
     * @param int $roleId
     *
     * @return array
     */
    public function fetchPermissionsByRole(int $roleId) : array
    {
        $pdos = $this->dBase->prepare('
        SELECT rp.permission_id AS objectId, name, description, last_update AS lastUpdate
        FROM permission AS p
        INNER JOIN role_permission AS rp 
        ON rp.permission_id = p.permission_id
        WHERE rp.role_id = :id');

        $pdos->bindParam(':id', $roleId, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Permission');
    }
    
    /**
     * Fetch User's permissions.
     *
     * @param int $userId
     *
     * @return array
     */
    public function fetchPermissionsByUser(int $userId) : array
    {
        $pdos = $this->dBase->prepare('
        SELECT up.permission_id AS objectId, name, description, last_update AS lastUpdate
        FROM permission AS p
        INNER JOIN user_permission AS up 
        ON up.permission_id = p.permission_id
        WHERE up.user_id = :id');

        $pdos->bindParam(':id', $userId, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Permission');
    }

    /**
     * Check if permission exist
     * 
     * @param string $permission
     * @return bool
     */
    public function permissionExist(string $permission) : bool
    {
        $pdos = $this->dBase->prepare('SELECT permission_id FROM permission WHERE name = :name');

        $pdos->bindParam(':name', $permission, \PDO::PARAM_STR);
        $pdos->execute();

        return ($pdos->rowCount() > 0) ? true : false;
    }

    /**
     * Create a new User DomainObject.
     *
     * @return User
     */
    protected function concreteCreate() : Permission
    {
        return new Permission();
    }

    /**
     * Insert the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $permission
     *
     * @throws \InvalidArgumentException
     *
     * @return int Last insert id
     */
    protected function concreteInsert(DomainObjectInterface $permission) : int
    {
        return 0;
    }

    /**
     * Update the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $permission
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteUpdate(DomainObjectInterface $permission)
    {
        
    }

    /**
     * Delete the DomainObject from persistent storage.
     *
     * @param DomainObjectAbstract $permission
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteDelete(DomainObjectInterface $permission)
    {
        
    }
}
