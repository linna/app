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

use Linna\Auth\Group;
use Linna\Auth\GroupMapperInterface;
use Linna\Auth\PermissionMapperInterface;
use Linna\Auth\User;
use Linna\DataMapper\DomainObjectAbstract;
use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\MapperAbstract;
use Linna\DataMapper\NullDomainObject;
use Linna\Storage\MysqlPdoAdapter;

/**
 * Group Mapper.
 */
class GroupMapper extends MapperAbstract implements GroupMapperInterface
{
    /**
     * @var \PDO Database Connection
     */
    protected $dBase;

    /**
     * @var PermissionMapperInterface Permission Mapper
     */
    protected $permissionMapper;
    
    /**
     * Constructor.
     *
     * @param MysqlPdoAdapter $dBase
     */
    public function __construct(MysqlPdoAdapter $dBase, PermissionMapperInterface $permissionMapper)
    {
        $this->dBase = $dBase->getResource();
        
        $this->permissionMapper = $permissionMapper;
    }

    /**
     * Fetch a permission by id.
     *
     * @param string $permissionId
     *
     * @return DomainObjectInterface
     */
    public function fetchById(int $permissionId) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT group_id AS objectId, name, description, active, last_update AS lastUpdate FROM group WHERE group_id = :id');

        $pdos->bindParam(':id', $permissionId, \PDO::PARAM_INT);
        $pdos->execute();

        $result = $pdos->fetchObject('\Linna\Auth\Group');

        return ($result instanceof Group) ? $result : new NullDomainObject();
    }

    /**
     * Fetch all permission stored in data base.
     *
     * @return array
     */
    public function fetchAll() : array
    {
        $pdos = $this->dBase->prepare('SELECT group_id AS objectId, name, description, active, last_update AS lastUpdate FROM group ');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Group');
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
        $pdos = $this->dBase->prepare('SELECT group_id AS objectId, name, description, active, last_update AS lastUpdate FROM group LIMIT :offset, :rowcount');

        $pdos->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $pdos->bindParam(':rowcount', $rowCount, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Group');
    }

    /**
     * Return an array with Group Permissions
     * 
     * @param int $groupId
     * @return array
     */
    public function fetchGroupPermissions(int $groupId) : array
    {
        return [];
    }
    
    /**
     * Return an array with Group Users
     * 
     * @param int $groupId
     * @return array
     */
    public function fetchUsersInGroup(int $groupId) : array
    {
        return [];
    }
    
    /**
     * Return permission inherited by an User from Groups
     * 
     * @param int $userId
     * @return array
     */
    public function fetchUserInheritedPermissions(int $userId) : array
    {
        return [];
    }
    
    /**
     * Grant a Permission to a Group
     * 
     * @param Group $group
     * @param string $permission
     */
    public function permissionGrant(Group &$group, string $permission)
    {
        
    }

    /**
     * Revoke a Permission to a Group
     * 
     * @param Group $group
     * @param string $permission
     */
    public function permissionRevoke(Group &$group, string $permission)
    {
        
    }
    
    /**
     * Add an User to a Group
     * 
     * @param Group $group
     * @param User $user
     */
    public function userAdd(Group &$group, User $user)
    {
        
    }

    /**
     * Remove an User from a Group
     * 
     * @param Group $group
     * @param User $user
     */
    public function userRemove(Group &$group, User $user)
    {
        
    }

    /**
     * Create a new User DomainObject.
     *
     * @return User
     */
    protected function concreteCreate() : Permission
    {
        return new Group();
    }

    /**
     * Insert the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $group
     *
     * @throws \InvalidArgumentException
     *
     * @return int Last insert id
     */
    protected function concreteInsert(DomainObjectInterface $group) : int
    {
        return 0;
    }

    /**
     * Update the DomainObject in persistent storage.
     *
     * @param DomainObjectInterface $group
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteUpdate(DomainObjectInterface $group)
    {

    }

    /**
     * Delete the DomainObject from persistent storage.
     *
     * @param DomainObjectAbstract $group
     *
     * @throws \InvalidArgumentException
     */
    protected function concreteDelete(DomainObjectInterface $group)
    {

    }
}
