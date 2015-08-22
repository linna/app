<?php

namespace App\Models;

use Leviu\Routing\Model;
use Leviu\Auth\Login;
use App\Lib\Tree;

class TreeTest extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function test()
    {
        $opt = [
            "table" => "tree",
            "primaryKey" => "tree_id",
            "treeNodeName" => "node_name",
            "treeNodeOrder" => "node_order",
            "treeParentId" => "tree_parent_id",
            "treeRoot" => "tree_root",
            "treeLeft" => "tree_left",
            "treeRight" => "tree_right",
        ];

        $tree = new Tree($opt);



        //$tree->buildTree();
        //$percorso = $tree->walkToNode(21);
        //var_dump($percorso);
        //$tree->insertNode(3, 'Child 21');

        //$test = $tree->getTree();

        return  $tree->getTree();
    }
}
