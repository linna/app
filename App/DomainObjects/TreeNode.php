<?php

/**
 * Leviu.
 *
 * This work would be a little PHP framework, a learn exercice. 
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2015, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 * @version 0.1.0
 */
namespace App\DomainObjects;

use Leviu\Database\DomainObjectAbstract;
use App\Mappers\TreeMapper;
/**
 * User
 * - Class for manage users.
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 */
class TreeNode extends DomainObjectAbstract
{
    /**
     * @var string User name
     */
    
    
    public $level;

    /**
     * @var string Node name
     */
    public $name;

    /**
     * @var string User password
     */
    //public $position;

    /**
     * @var int It say if user is active or not
     */
    //public $is_root;

    /**
     * @var string User creation date
     */
    protected $lft;

    /**
     * @var string Last user update
     */
    protected $rgt;

    //private $mapper;
    
    /**
     * User Constructor.
     * 
     * Do type conversion because PDO doesn't return any original type from db :(
     * 
     * @since 0.1.0
     */
    public function __construct()
    {
        //$this->active = (int) $this->active;
        settype($this->_id, 'integer');
        //settype($this->parent_id, 'integer');
        settype($this->level, 'integer');
        //settype($this->position, 'integer');
        //settype($this->is_root, 'integer');
        settype($this->lft, 'integer');
        settype($this->rgt, 'integer');
    }
    
    
    public function appendFirst(DomainObjectAbstract &$nodeToAppend)
    {
        $mapper = new \App\Mappers\TreeMapper();
        $nodeToAppend = $mapper->insertAsFirstChild($nodeToAppend, $this);
    }
    
    public function appendLast(DomainObjectAbstract &$nodeToAppend)
    {
        $mapper = new \App\Mappers\TreeMapper();
        $nodeToAppend = $mapper->insertAsLastChild($nodeToAppend, $this);
    }
    
    public function delete()
    {
       $mapper = new \App\Mappers\TreeMapper();
       $mapper->delete($this);
    }
    
    public function __get($name)
    {
        return $this->$name;
    }
}
