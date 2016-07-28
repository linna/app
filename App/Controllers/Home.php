<?php

namespace App\Controllers;

use Leviu\Routing\Controller;
use Leviu\Auth\Login;

class Home extends Controller
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
        $this->view->setTitle('App/Home');

        $this->view->render('Home/index');
        
        $treeMapper = new \App\Mappers\TreeMapper;
       
        $tree = $treeMapper->getTree();
        
        echo '<p style="margin-top:20px;">recupero intero albero</p>';
        
        foreach ($tree as $treeNode) {
            echo str_repeat('--', $treeNode->level).$treeNode->getId().'_'.$treeNode->name.' '.$treeNode->lft.'_'.$treeNode->rgt.'<br/>';
        }   
        
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
        
        
        //updating a node
        //$node = $treeMapper->getNodeById(3);
        //$node->name = 'Nodo Prova D';

        //$treeMapper->save($node);
        
        //create a node
        //$parentNode = $treeMapper->getNodeById(3);
        
        //$node1 = $treeMapper->create();
        //$node1->name = 'Child Node 1';
        //$treeMapper->save($node1, $parentNode);
        
        //$node2 = $treeMapper->create();
        //$node2->name = 'Child Node 2';
        //$parentNode->appendFirst($node2);
        
        
        //delete a node: ways
        //$node = $treeMapper->getNodeById(2);
        //$node->delete();
        
        //$node = $treeMapper->getNodeById(3);
        //$treeMapper->delete($node);
        
        
        
        
        //$node = $treeMapper->getNodeById(3);
        
        //var_dump($node);
               
        $tree = $treeMapper->getTree();
        
        echo '<p style="margin-top:20px;">recupero intero albero dopo</p>';
        
        foreach ($tree as $treeNode) {
           //var_Dump($treeNode);
            
            echo str_repeat('--', $treeNode->level).$treeNode->getId().'_'.$treeNode->name.' '.$treeNode->lft.'_'.$treeNode->rgt.'<br/>';
        }
        
    }
}
