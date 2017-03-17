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

use Linna\Auth\EnhancedUser;
use Linna\Auth\EnhancedUserMapperInterface;
use Linna\Auth\Password;
use Linna\Auth\PermissionMapperInterface;
use Linna\DataMapper\DomainObjectAbstract;
use Linna\DataMapper\DomainObjectInterface;
use Linna\DataMapper\NullDomainObject;
use Linna\Storage\MysqlPdoAdapter;

/**
 * EnhancedUserMapper.
 */
class EnhancedUserMapper extends UserMapper implements EnhancedUserMapperInterface
{
    /**
     * @var PermissionMapperInterface Permission Mapper
     */
    protected $permissionMapper;
    
    /**
     * Constructor.
     *
     * @param MysqlPdoAdapter $dBase
     * @param Password $password
     * @param PermissionMapperInterface $permissionMapper
     */
    public function __construct(MysqlPdoAdapter $dBase, Password $password, PermissionMapperInterface $permissionMapper)
    {
        parent::__construct($dBase, $password);
        
        $this->permissionMapper = $permissionMapper;
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

        $user = $pdos->fetchObject('\Linna\Auth\EnhancedUser', [$this->password]);
        
        if (!($user instanceof EnhancedUser)) {
            return new NullDomainObject;
        }
        
        $user->setPermissions($this->permissionMapper->fetchUserPermission($userId));
        
        return $user;
    }

    /**
     * Fetch a user object by name.
     *
     * @param string $userName
     *
     * @return DomainObjectInterface
     */
    public function fetchByName(string $userName) : DomainObjectInterface
    {
        $pdos = $this->dBase->prepare('SELECT user_id AS objectId, name, email, description, password, active, created, last_update AS lastUpdate FROM user WHERE md5(name) = :name');

        $hashedUserName = md5($userName);

        $pdos->bindParam(':name', $hashedUserName, \PDO::PARAM_STR);
        $pdos->execute();

        $user = $pdos->fetchObject('\Linna\Auth\EnhancedUser', [$this->password]);
        
        if (!($user instanceof EnhancedUser)) {
            return new NullDomainObject;
        }
        
        $user->setPermissions($this->permissionMapper->fetchUserPermission($user->getId()));
        
        return $user;
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

        $users = $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\EnhancedUser', [$this->password]);
        
        return $this->setPermissionsToUsersArray($users);
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

        $users = $pdos->fetchAll(\PDO::FETCH_CLASS, '\Linna\Auth\EnhancedUser', [$this->password]);
        
        return $this->setPermissionsToUsersArray($users);
    }
    
    /**
     * Set Permission on every EnhancedUser instance inside an array
     * 
     * @param array $users
     * @return array
     */
    protected function setPermissionsToUsersArray(array $users) : array
    {
        $arrayUsers = [];
        
        foreach ($users as $user)
        {
            $user->setPermissions($this->permissionMapper->fetchUserPermission($user->getId()));
            $arrayUsers[] = $user;
        }
        
        return $arrayUsers;
    }
    
    /**
     * Grant permission to User
     * 
     * @param EnhancedUser $user
     * @param string $permission
     */
    public function grant(EnhancedUser &$user, string $permission)
    {
        if ($this->permissionMapper->permissionExist($permission))
        {
            $pdos = $this->dBase->prepare('INSERT INTO user_permission (user_id, permission_id) VALUES (:user_id, (SELECT permission_id FROM permission WHERE name = :permission))');
            
            $userId = $user->getId();
            
            $pdos->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $pdos->bindParam(':permission', $permission, \PDO::PARAM_STR);
            $pdos->execute();
            
            $user->setPermissions($this->permissionMapper->fetchUserPermission($userId));
        }
    }
    
    /**
     * Revoke permission to User
     * 
     * @param EnhancedUser $user
     * @param string $permission
     */
    public function revoke(EnhancedUser &$user, string $permission)
    {
        if ($this->permissionMapper->permissionExist($permission))
        {
            $pdos = $this->dBase->prepare('DELETE FROM user_permission WHERE user_id = :user_id AND permission_id = (SELECT permission_id FROM permission WHERE name = :permission)');
            
            $userId = $user->getId();
            
            $pdos->bindParam(':user_id', $userId, \PDO::PARAM_INT);
            $pdos->bindParam(':permission', $permission, \PDO::PARAM_STR);
            $pdos->execute();
            
            $user->setPermissions($this->permissionMapper->fetchUserPermission($userId));
        }
    }
    
    /**
     * Create a new User DomainObject.
     *
     * @return User
     */
    protected function concreteCreate() : User
    {
        return new EnhancedUser($this->password);
    }
}
