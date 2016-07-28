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
namespace App\Mappers;

use Leviu\Database\DomainObjectAbstract;
use Leviu\Database\MapperAbstract;
use Leviu\Database\Database;
use App\DomainObjects\TreeNode;

/**
 * UserMapper.
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 */
class TreeMapper extends MapperAbstract
{
    /**
     * @var object Database Connection
     */
    protected $db;

    /**
     * UserMapper Constructor.
     * 
     * Open only a database connection
     *
     * @since 0.1.0
     */
    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * findById.
     * 
     * Fetch a user object by id
     * 
     * @param string $id
     *
     * @return User
     *
     * @since 0.1.0
     */
    public function getNodeById($id)
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            #node.tree_parent_id AS parent_id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
            #node.node_order as position,
            #node.tree_root as is_root,
            node.tree_left as lft,
            node.tree_right as rgt,
            node.last_update
        FROM
            tree AS node,
            tree AS parent
        WHERE node.tree_left BETWEEN parent.tree_left AND parent.tree_right
        AND (node.tree_left <= (SELECT tree_left FROM tree WHERE tree_id = :id) 
        AND node.tree_right >= (SELECT tree_left FROM tree WHERE tree_id = :id))
        AND node.tree_id = :id
        GROUP BY node.tree_id
        ORDER BY node.tree_left ASC');

        $pdos->bindParam(':id', $id, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\TreeNode');//$this->create($pdos->fetch());
    }

    /**
     * findByName.
     * 
     * Fetch a user object by name
     * 
     * @param string $name
     *
     * @return User
     *
     * @since 0.1.0
     */
   /* public function getNodeByName($name)
    {
        $pdos = $this->db->prepare('SELECT 
            tree_id AS _id,
            tree_parent_id AS parent_id,
            node_name AS name,
            node_order as position,
            tree_root as is_root,
            tree_left as lft,
            tree_right as rgt,
            last_update
        FROM
            tree
        WHERE md5(node_name) = :name');

        $hashedTreeName = md5($name);

        $pdos->bindParam(':name', $hashedTreeName, \PDO::PARAM_STR);
        $pdos->execute();

        return $pdos->fetchObject('\App\DomainObjects\Tree');//$this->create($pdos->fetch());
    }*/

    public function getTree()
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            #node.tree_parent_id AS parent_id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
            #node.node_order as position,
            #node.tree_root as is_root,
            node.tree_left as lft,
            node.tree_right as rgt,
            node.last_update
        FROM
            tree AS node,
            tree AS parent
        WHERE node.tree_left BETWEEN parent.tree_left AND parent.tree_right
        GROUP BY node.tree_id
        ORDER BY node.tree_left ASC');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\TreeNode');
    }
    
    public function getTreeRoot()
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            #node.tree_parent_id AS parent_id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
            #node.node_order as position,
            #node.tree_root as is_root,
            node.tree_left as lft,
            node.tree_right as rgt,
            node.last_update
        FROM
            tree AS node,
            tree AS parent
        WHERE node.tree_left = (SELECT MIN(tree_left) AS tree_left FROM tree)
        GROUP BY node.tree_id
        ORDER BY node.tree_left ASC');

        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\TreeNode');
    }
    
    public function getSubTree($id)
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            #node.tree_parent_id AS parent_id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
            #node.node_order as position,
            #node.tree_root as is_root,
            node.tree_left as lft,
            node.tree_right as rgt,
            node.last_update
        FROM
            tree AS node,
            tree AS parent
        WHERE node.tree_left BETWEEN parent.tree_left AND parent.tree_right
        AND parent.tree_left >= (SELECT tree_left FROM tree WHERE tree_id = :id) 
        AND parent.tree_right <= (SELECT tree_right FROM tree WHERE tree_id = :id)
        GROUP BY node.tree_id
        ORDER BY node.tree_left ASC');
       
        $pdos->bindParam(':id', $id, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\TreeNode'); 
    }
    
    public function getNodePath($id)
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            #node.tree_parent_id AS parent_id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
            #node.node_order as position,
            #node.tree_root as is_root,
            node.tree_left as lft,
            node.tree_right as rgt,
            node.last_update
        FROM
            tree AS node,
            tree AS parent
        WHERE node.tree_left BETWEEN parent.tree_left AND parent.tree_right
        AND (node.tree_left <= (SELECT tree_left FROM tree WHERE tree_id = :id) 
        AND node.tree_right >= (SELECT tree_left FROM tree WHERE tree_id = :id))
        GROUP BY node.tree_id
        ORDER BY node.tree_left ASC');
       
        $pdos->bindParam(':id', $id, \PDO::PARAM_INT);
        $pdos->execute();

        return $pdos->fetchAll(\PDO::FETCH_CLASS, '\App\DomainObjects\TreeNode'); 
    }
    
    
    //public function delete()
    //{}
    
    /**
     * populate.
     * 
     * Populate the User (DomainObject) with
     * the data.
     * 
     * @param DomainObjectAbstract $obj
     * @param object               $data
     *
     * @return User
     *
     * @since 0.1.0
     * @deprecated since version 0.1.0 Replaced with \PDO::FETCH_CLASS fetch option
     */
    //public function populate(DomainObjectAbstract $obj, $data)
    //{
       /* $obj->setId($data->user_id);
        $obj->name = $data->name;
        $obj->description = $data->description;
        $obj->password = $data->password;
        $obj->active = (int) $data->active;
        $obj->created = $data->created;
        $obj->last_update = $data->last_update;

        return $obj;*/
    //}
    
    public function save(DomainObjectAbstract ...$treeNode)//, DomainObjectAbstract $parentNode)
    {
        $parentNode = isset($treeNode[1]) ? $treeNode[1] : null;
        $treeNode = $treeNode[0];
        
        if ($treeNode->getId() === 0) {
            return $this->_tree_insert($treeNode, $parentNode);
           
        } else {
            return $this->_update($treeNode);
        }
    }
    
    
    /**
     * _create.
     * 
     * Create a new User DomainObject
     *
     * @return User
     *
     * @since 0.1.0
     */
    protected function _create()
    {
        return new TreeNode();
    }

    /**
     * _insert.
     * 
     * Insert the DomainObject in persistent storage
     * 
     * This may include connecting to the database
     * and running an insert statement.
     *
     * @param DomainObjectAbstract $obj
     *
     * @since 0.1.0
     */
    protected function _insert(DomainObjectAbstract $treeNode)
    {
        return null;
    }
    
    protected function _tree_insert(DomainObjectAbstract $treeNode, DomainObjectAbstract $parentNode)
    {   
                
        $this->db->beginTransaction();
                
        //find tree left of new node parent id
        //$pdos = $this->db->prepare('SELECT tree_left FROM tree WHERE tree_id = :id');
        //$pdos->bindParam(':id', $treeNode->parent_id, \PDO::PARAM_INT);
        //$pdos->execute();
        
        //$tree_left = (int) $pdos->fetch(\PDO::FETCH_OBJ)->tree_left;
        
        $tree_left = $parentNode->lft;
        
        //update right side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_right = tree_right + 2 WHERE tree_right > :left');
        $pdos->bindParam(':left', $tree_left, \PDO::PARAM_INT);
        $pdos->execute();
        
        //update left side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_left = tree_left + 2 WHERE tree_left > :left');
        $pdos->bindParam(':left', $tree_left, \PDO::PARAM_INT);
        $pdos->execute();
        
        
        //insert new tree node
        $pdos = $this->db->prepare('INSERT INTO tree (tree_parent_id, node_name, node_order, tree_root, tree_left, tree_right) 
        VALUES (0, :name, 0, 0, :left, :right)');

        $left = $tree_left + 1;
        $right = $tree_left + 2;
        
        //$pdos->bindParam(':parent_id', $obj->parent_id, \PDO::PARAM_INT);//ok
        $pdos->bindParam(':name', $treeNode->name, \PDO::PARAM_STR);
        $pdos->bindParam(':left', $left, \PDO::PARAM_INT);
        $pdos->bindParam(':right', $right, \PDO::PARAM_INT);
        $pdos->execute();
        
        //find new node and return it
        $newNodeId = (int) $this->db->lastInsertId();
        
        $this->db->commit();
        
        return $this->getNodeById($newNodeId);
        
    }

    /**
     * _update.
     * 
     * Update the DomainObject in persistent storage
     * 
     * This may include connecting to the database
     * and running an update statement.
     *
     * @param DomainObjectAbstract $obj
     *
     * @since 0.1.0
     */
    protected function _update(DomainObjectAbstract $treeNode)
    {
        $pdos = $this->db->prepare('UPDATE tree SET node_name = :name WHERE tree_id = :id');
        
        $tree_id = $treeNode->_id;
        
        $pdos->bindParam(':id', $tree_id, \PDO::PARAM_INT);
        $pdos->bindParam(':name', $treeNode->name, \PDO::PARAM_STR);
       
        $pdos->execute();
    }

    /**
     * __delete.
     * 
     * Delete the DomainObject from persistent storage
     * 
     * This may include connecting to the database
     * and running a delete statement.
     *
     * @param DomainObjectAbstract $obj
     *
     * @since 0.1.0
     */
    protected function _delete(DomainObjectAbstract $treeNode)
    {
            
        $tree_id = $treeNode->getId();
        $tree_left = (int) $treeNode->lft;
        $tree_right = (int) $treeNode->rgt;
        $tree_width = (int) ($tree_right - $tree_left + 1);
        
        
        $this->db->beginTransaction();
                
        //find tree left, tree right, tree width for node
        /*$pdos = $this->db->prepare('SELECT tree_left, tree_right, (tree_right - tree_left + 1) AS tree_width FROM tree WHERE tree_id = :id');
        $pdos->bindParam(':id', $tree_id, \PDO::PARAM_INT);
        $pdos->execute();
        
        $pdos_tmp = $pdos->fetch(\PDO::FETCH_OBJ);*/
        
        //update right side of nodes
        $pdos = $this->db->prepare('DELETE FROM tree WHERE tree_left BETWEEN :left AND :right');
        $pdos->bindParam(':left', $tree_left, \PDO::PARAM_INT);
        $pdos->bindParam(':right', $tree_right, \PDO::PARAM_INT);
        $pdos->execute();
        
        //update right side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_right = tree_right - :width WHERE tree_right > :right');
        $pdos->bindParam(':right', $tree_right, \PDO::PARAM_INT);
        $pdos->bindParam(':width', $tree_width, \PDO::PARAM_INT);
        $pdos->execute();
        
        //update left side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_left = tree_left - :width WHERE tree_left > :right');
        $pdos->bindParam(':right', $tree_right, \PDO::PARAM_INT);
        $pdos->bindParam(':width', $tree_width, \PDO::PARAM_INT);
        $pdos->execute();
                
        $this->db->commit();
        
        //return $this->getNodeById($newNodeId);
    }
}
