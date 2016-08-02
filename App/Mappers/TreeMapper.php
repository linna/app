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
     * TreeMapper Constructor.
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
     * getNodeById.
     * 
     * Fetch a TreeNode object by id
     * 
     * @param int $id
     *
     * @return TreeNode
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
     * getTree
     * 
     * @return TreeNode
     */
    public function getTree()
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
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
    
    /**
     * getTreeRoot
     * 
     * @return array
     */
    public function getTreeRoot()
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
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
    
    /**
     * getSubTree
     * 
     * @param int $id
     * @return array
     */
    public function getSubTree($id)
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
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
    
    /**
     * getNodePath
     * 
     * @param int $id
     * @return array
     */
    public function getNodePath($id)
    {
        $pdos = $this->db->prepare('
        SELECT 
            node.tree_id AS _id,
            (COUNT(parent.tree_id) - 1) AS level,
            node.node_name AS name,
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
    
    
    /**
     * save
     * 
     * Overrides parent method for save objects in
     * persistent storage
     *  
     * @param DomainObjectAbstract $treeNode
     * @param DomainObjectAbstract $parentNode
     * 
     * @return DomainObjectAbstract tree node
     */ 
    public function save(DomainObjectAbstract ...$treeNode)
    {
        $parentNode = isset($treeNode[1]) ? $treeNode[1] : null;
        $treeNode = $treeNode[0];
        
        if ($treeNode->getId() === 0) {
            return $this->insertAsFirstChild($treeNode, $parentNode);
           
        } else {
            return $this->_update($treeNode);
        }
    }
    
    
    /**
     * _create.
     * 
     * Create a new User DomainObject
     *
     * @return TreeNode
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
     * In this mapper not utilized
     *
     * @param DomainObjectAbstract $treeNode
     *
     * @since 0.1.0
     */
    protected function _insert(DomainObjectAbstract $treeNode)
    {
        
    }
    
    public function move(DomainObjectAbstract $treeNode)
    {
        
    }
    
    public function moveAfter()
    {
        
    }
    
    public function moveBefore()
    {
        
    }
    
    /**
     * insertAsFirstChild
     * 
     * Insert the DomainObject treeNode in persistent storage
     * as first child of a parent node
     * 
     * @param DomainObjectAbstract $treeNode
     * @param DomainObjectAbstract $parentNode
     * 
     * @return DomainObjectAbstract tree node
     */
    public function insertAsFirstChild(DomainObjectAbstract $treeNode, DomainObjectAbstract $parentNode)
    {   
                
        $this->db->beginTransaction();
                
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
     * insertAsLastChild
     * 
     * Insert the DomainObject treeNode in persistent storage
     * as last child of a parent node
     * 
     * @param DomainObjectAbstract $treeNode
     * @param DomainObjectAbstract $parentNode
     * 
     * @return DomainObjectAbstract tree node
     */
    public function insertAsLastChild(DomainObjectAbstract $treeNode, DomainObjectAbstract $parentNode)
    {
        $this->db->beginTransaction();
                
        $tree_right = $parentNode->rgt;
        
        //update right side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_right = tree_right + 2 WHERE tree_right > :right -1');
        $pdos->bindParam(':right', $tree_right, \PDO::PARAM_INT);
        $pdos->execute();
        
        //update left side of nodes
        $pdos = $this->db->prepare('UPDATE tree SET tree_left = tree_left + 2 WHERE tree_left > :right -1');
        $pdos->bindParam(':right', $tree_right, \PDO::PARAM_INT);
        $pdos->execute();
        
        //insert new tree node
        $pdos = $this->db->prepare('INSERT INTO tree (tree_parent_id, node_name, node_order, tree_root, tree_left, tree_right) 
        VALUES (0, :name, 0, 0, :left, :right)');

        $left = $tree_right;
        $right = $tree_right + 1;
        
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
     * @param DomainObjectAbstract $treeNode
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
     * @param DomainObjectAbstract $treeNode
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
      
    }
}
