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

use Linna\Auth\Permission;
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function fetchAll() : array
    {
        $pdos = $this->dBase->prepare('SELECT permission_id AS objectId, name, description, last_update AS lastUpdate FROM permission');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\Permission');
    }

    /**
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
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
     * {@inheritDoc}
     */
    public function generatePermissionHashTable() : array
    {
        $pdos = $this->dBase->query("(SELECT sha2(concat(u.user_id, '.', up.permission_id),0) as p_hash
            FROM user AS u
            INNER JOIN user_permission AS up
            ON u.user_id = up.permission_id)

            UNION

            (SELECT sha2(concat(u.user_id, '.', rp.permission_id),0) as p_hash
            FROM user AS u
            INNER JOIN user_role AS ur
            INNER JOIN role AS r
            INNER JOIN role_permission as rp
            ON u.user_id = ur.user_id
            AND ur.role_id = r.role_id
            AND r.role_id = rp.role_id)

            ORDER BY p_hash");

        return array_flip($pdos->fetchAll(\PDO::FETCH_COLUMN));
    }

    /**
     * {@inheritDoc}
     */
    public function permissionExist(string $permission) : bool
    {
        $pdos = $this->dBase->prepare('SELECT permission_id FROM permission WHERE name = :name');

        $pdos->bindParam(':name', $permission, \PDO::PARAM_STR);
        $pdos->execute();

        return ($pdos->rowCount() > 0) ? true : false;
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteCreate() : DomainObjectInterface
    {
        return new Permission();
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteInsert(DomainObjectInterface $permission) : int
    {
        return 0;
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteUpdate(DomainObjectInterface $permission)
    {
    }

    /**
     * {@inheritDoc}
     */
    protected function concreteDelete(DomainObjectInterface $permission)
    {
    }
}
