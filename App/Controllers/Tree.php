<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login;

class Tree extends Controller
{
    use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        parent::__construct(__CLASS__);

        $this->protectMethod(new Login());

        $this->view->data->isLogged = $this->isLogged;
        $this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $this->view->setTitle('App/Tree');

        $this->view->render('Tree');
        
       /* $treeMapper = new \App\Mappers\TreeMapper;
       
        $tree = $treeMapper->getTree();
        
        echo '<table><tr><td><p style="margin-top:20px;">recupero intero albero</p>';
        
        foreach ($tree as $treeNode) {
            echo str_repeat('----', $treeNode->level).$treeNode->getId().'_'.$treeNode->name.' '.$treeNode->lft.'_'.$treeNode->rgt.'<br/>';
        }   
        
        echo '</td>';*/
        
        /*
        
        $tree = $treeMapper->getSubTree(4);
        
        echo '<p style="margin-top:20px;">pezzo di albero</p>';
        
        foreach ($tree as $treeNode) {
            echo str_repeat('--', $treeNode->level).' '.$treeNode->name.'<br/>';
        }
        
        $tree = $treeMapper->getNodePath(15);
        
        echo '<p style="margin-top:20px;">percorso per radice</p>';
        
        foreach ($tree as $treeNode) {
            echo str_repeat('--', $treeNode->level).' '.$treeNode->name.'<br/>';
        }  
        */
        
        //if target position is before a node, newpos = left position of this node

        //if target position is into a node (as a child), newpos = left position of this node + 1

        //if target position is after a node, newpos = right position of this node + 1

        //move node
        //$targetNode = $treeMapper->getNodeById(8);
        //$nodeToMove = $treeMapper->getNodeById(3);

        //$nodeToMove->moveBefore($targetNode);
        //$nodeToMove->moveAfter($targetNode);
        //$nodeToMove->moveInto($targetNode);


        //updating a node
        //$node = $treeMapper->getNodeById(3);
        //$node->name = 'Node Test D';
        //$treeMapper->save($node);

        
        
        //create a node
        //$parentNode = $treeMapper->getNodeById(1);

        //default insert method (insert as first child)
        //$node0 = $treeMapper->create();
        //$node0->name = 'Child Node 0';
        //$treeMapper->save($node0, $parentNode);

        //insert as first child using mapper
        //$node1 = $treeMapper->create();
        //$node1->name = 'Child Node 1';
        //$treeMapper->insertAsFirstChild($node1, $parentNode);

        //insert as first using parent node shortcut/link to mapper
        //$node3 = $treeMapper->create();
        //$node3->name = 'Child Node 3';
        //$parentNode->appendFirst($node3);

        //insert as last child using mapper
        //$parentNode = $treeMapper->getNodeById(1);
        //$node2 = $treeMapper->create();
        //$node2->name = 'Child Node 2';
        //$treeMapper->insertAsLastChild($node2, $parentNode);

        //insert as last using parent node shortcut/link to mapper
        //$parentNode = $treeMapper->getNodeById(1);
        //$node4 = $treeMapper->create();
        //$node4->name = 'Child Node 4';
        //$parentNode->appendLast($node4);

        //delete a node using node shortcut/link to mapper
        //$node = $treeMapper->getNodeById(2);
        //$node->delete();

        //delete a node using mapper
        //$node = $treeMapper->getNodeById(3);
        //$treeMapper->delete($node);

        
        
               
       /* $tree = $treeMapper->getTree();
        
        echo '<td><p style="margin-top:20px;">recupero intero albero dopo</p>';
        
        foreach ($tree as $treeNode) {
           //var_Dump($treeNode);
            
            echo str_repeat('----', $treeNode->level).$treeNode->getId().'_'.$treeNode->name.' '.$treeNode->lft.'_'.$treeNode->rgt.'<br/>';
        }
        
        echo '</td></tr></table>';*/
    }
}
