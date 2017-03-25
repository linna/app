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

use Linna\Auth\EnhancedUserMapperInterface;
use Linna\Auth\Password;
use Linna\Auth\PermissionMapperInterface;
use Linna\Auth\Role;
use Linna\Auth\RoleMapperInterface;
use Linna\Auth\User;
use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\MapperAbstract;
use Linna\DataMapper\NullDomainObject;
use Linna\Storage\MysqlPdoAdapter;

/**
 * Role Mapper.
 */
class RoleMapper extends MapperAbstract implements RoleMapperInterface
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
     * @var PermissionMapperInterface Permission Mapper
     */
    protected $permissionMapper;

    /**
     * @var EnhancedUserMapperInterface Permission Mapper
     */
    protected $userMapper;

    /**
     * Constructor.
     *
     * @param MysqlPdoAdapter $dBase
     */
    public function __construct(
            MysqlPdoAdapter $dBase,
            Password $password,
            EnhancedUserMapperInterface $userMapper,
            PermissionMapperInterface $permissionMapper)
    {
        $this->dBase = $dBase->getResource();
        $this->password = $password;
        $this->userMapper = $userMapper;
        $this->permissionMapper = $permissionMapper;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchById(int $roleId) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT role_id AS objectId, name, description, active, last_update AS lastUpdate FROM role WHERE role_id = :id');

        $pdos->bindParam(':id', $roleId, \PDO::PARAM_INT);
        $pdos->execute();

        $role = $pdos->fetchObject('\Linna\Auth\Role');

        if (!($role instanceof Role)) {
            return new NullDomainObject();
        }

        $roleUsers = $this->userMapper->fetchUserByRole($roleId);
        $rolePermissions = $this->permissionMapper->fetchPermissionsByRole($roleId);

        $role->setUsers($roleUsers);
        $role->setPermissions($rolePermissions);

        return $role;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchAll() : array
    {
        $pdos = $this->dBase->prepare('SELECT role_id AS objectId, name, description, active, last_update AS lastUpdate FROM role ');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Role');
    }

    /**
     * {@inheritDoc}
     */
    public function fetchLimit(int $offset, int $rowCount) : array
    {
        $pdos = $this->dBase->prepare('SELECT role_id AS objectId, name, description, active, last_update AS lastUpdate FROM groups LIMIT :offset, :rowcount');

        $pdos->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $pdos->bindParam(':rowcount', $rowCount, \PDO::PARAM_INT);
        $pdos->execute();

        $roles = $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Role');

        return $this->fillRolesArray($roles);
    }

    /**
     * Set Permission and Users on every Role instance inside passed array.
     *
     * @param array $roles
     *
     * @return array
     */
    protected function fillRolesArray(array $roles) : array
    {
        $arrayRoles = [];

        foreach ($roles as $role) {
            $roleUsers = $this->userMapper->fetchUserByRole($roleId);
            $rolePermissions = $this->permissionMapper->fetchPermissionsByRole($roleId);

            $role->setUsers($roleUsers);
            $role->setPermissions($rolePermissions);
            $arrayRoles[] = $role;
        }

        return $arrayRoles;
    }

    /**
     * {@inheritDoc}
     */
    public function fetchUserInheritedPermissions(Role &$role, User $user) : array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function permissionGrant(Role &$role, string $permission)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function permissionRevoke(Role &$role, string $permission)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function userAdd(Role &$role, User $user)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function userRemove(Role &$role, User $user)
    {
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteCreate() : DomainObjectInterface
    {
        return new Role();
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteInsert(DomainObjectInterface $role) : int
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteUpdate(DomainObjectInterface $role)
    {
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteDelete(DomainObjectInterface $role)
    {
    }
}
