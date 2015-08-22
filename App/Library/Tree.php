<?php

namespace App\Lib;

class Tree
{
    use \App_mk0\OptSystemTrait;
    protected $table;
    protected $primaryKey;
    protected $treeNodeName;
    protected $treeNodeOrder;
    protected $treeParentId;
    protected $treeRoot;
    protected $treeLeft;
    protected $treeRight;
    private $db;

    public function __construct($options)
    {
        $this->optDefault = [
            "table" => "",
            "primaryKey" => "",
            "treeNodeName" => "",
            "treeNodeOrder" => "",
            "treeParentId" => "",
            "treeRoot" => "",
            "treeLeft" => "",
            "treeRight" => "",
        ];

        try {
            $this->optCheck($options);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }

        // $this->pippo = 0;

        $this->table = $this->opt["table"];
        $this->primaryKey = $this->opt["primaryKey"];
        $this->treeNodeName = $this->opt["treeNodeName"];
        $this->treeNodeOrder = $this->opt["treeNodeOrder"];
        $this->treeParentId = $this->opt["treeParentId"];
        $this->treeRoot = $this->opt["treeRoot"];
        $this->treeLeft = $this->opt["treeLeft"];
        $this->treeRight = $this->opt["treeRight"];

        $this->opt = null;
        $this->optDefault = null;

        $this->db = \App_mk0\Database::connect();
    }

    public function insertNode($parentId, $name, $root = 0)
    {
        $sql0 = "SELECT IFNULL(max({$this->treeNodeOrder}),0) + 1 AS nodeOrder FROM {$this->table} WHERE {$this->treeParentId} = :parent_id";

        $pdos0 = $this->db->prepare($sql0);
        $pdos0->bindParam(':parent_id', $parentId, \PDO::PARAM_INT);
        $pdos0->execute();

        $order = $pdos0->fetch()->nodeOrder;

        $sql1 = "INSERT INTO {$this->table} ({$this->treeParentId}, {$this->treeNodeName}, {$this->treeNodeOrder}, {$this->treeRoot}, {$this->treeLeft}, {$this->treeRight}) 
        VALUES (:parent_id, :name, :order, :root, 0, 0)";


        $pdos1 = $this->db->prepare($sql1);
        $pdos1->bindParam(':parent_id', $parentId, \PDO::PARAM_INT);
        $pdos1->bindParam(':name', $name, \PDO::PARAM_STR);
        $pdos1->bindParam(':order', $order, \PDO::PARAM_INT);
        $pdos1->bindParam(':root', $root, \PDO::PARAM_INT);
        $pdos1->execute();

        $lastInsertId = $this->db->lastInsertId();
        //completare con la query e poi fare una funzione per riordinare
        // do una nuova posizione se guadagno posti tutti quelli dopo li incremento di 1
        // se invece perdo tutti quelli maggiori della vecchia posizione e minori della nuova li diminuisco di 1 :) dovrebbe essere belle che fatta!

        $this->buildTree();

        return $lastInsertId;
    }

    public function changeNodeOrder($recordId, $nodeOrder)
    {
    }

    public function dropNode($recordId)
    {
        $pdos = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
        $pdos->bindParam(':id', $recordId, \PDO::PARAM_INT);
        $pdos->execute();

        $this->buildTree();
    }

    public function moveNode($recordId, $newParentId)
    {
        $pdos = $this->db->prepare("UPDATE {$this->table} SET {$this->treeParentId} = :parent_id  WHERE ($this->primaryKey) = :id");
        $pdos->bindParam(':id', $recordId);
        $pdos->bindParam(':parent_id', $newParentId, \PDO::PARAM_INT);
        $pdos->execute();

        $this->buildTree();
    }

    public function walkToNode($recordId)
    {
        $sql = "SELECT {$this->primaryKey} AS id FROM  {$this->table} WHERE 
        {$this->treeLeft} < (SELECT {$this->treeLeft} AS t_left FROM {$this->table} WHERE {$this->primaryKey} = :id) AND
        {$this->treeRight} > (SELECT {$this->treeRight} AS t_right FROM {$this->table} WHERE {$this->primaryKey} = :id)
        ORDER BY {$this->treeLeft} ASC";

        $pdos = $this->db->prepare($sql);
        $pdos->bindParam(':id', $recordId, \PDO::PARAM_INT);
        $pdos->execute();

        $treeArray = [];
        while ($record = $pdos->fetch()) {
            $treeArray[] = (int) $record->id;
        }

        return $treeArray;
    }

    public function getTree()
    {
        $rootNode = $this->getRootNode();

        $sql = "SELECT {$this->primaryKey} AS id, {$this->treeNodeName} AS nodeName, {$this->treeLeft} AS t_left , {$this->treeRight} AS t_right
        FROM {$this->table} WHERE {$this->treeLeft} BETWEEN
        (SELECT {$this->treeLeft} FROM {$this->table} WHERE {$this->primaryKey} = :id)
        AND (SELECT {$this->treeRight} FROM {$this->table} WHERE {$this->primaryKey} = :id)
        ORDER BY {$this->treeLeft} ASC";

        $pdos = $this->db->prepare($sql);
        $pdos->bindParam(':id', $rootNode, \PDO::PARAM_INT);
        $pdos->execute();

        $right = [];
        $treeArray = [];
        while ($record = $pdos->fetch()) {
            if (count($right) > 0) {
                while ($right[count($right) - 1] < $record->t_right) {
                    array_pop($right);
                }
            }

            $nestingLevel = count($right);
            $right[] = $record->t_right;

            $treeArray[] = (object) [
                        'nodeId' => (int) $record->id,
                        'nodeName' => (string) $record->nodeName,
                        'nestingLevel' => $nestingLevel,
                        't_left' => (int) $record->t_left,
                        't_right' => (int) $record->t_right
            ];
        }

        return $treeArray;
    }

    protected function getRootNode()
    {
        $pdos = $this->db->query("SELECT {$this->primaryKey} AS root, {$this->treeRoot} AS root_p FROM {$this->table} WHERE {$this->treeRoot} = 1");

        return $pdos->fetch()->root;
    }

    protected function buildTree($left = 0, $parentId = 0)
    {
        $sql = "SELECT {$this->primaryKey} AS id FROM {$this->table} WHERE {$this->treeParentId} = {$left} ORDER BY {$this->treeNodeOrder} ASC";

        if ($left == 0) {
            $this->resetTree();
            $sql = "SELECT {$this->primaryKey} AS id FROM {$this->table} WHERE {$this->treeRoot} = 1 ORDER BY {$this->treeNodeOrder} ASC";
        }

        $right = (int) $parentId + 1;

        $pdos = $this->db->query($sql);

        while ($record = $pdos->fetch()) {
            $right = $this->buildTree($record->id, $right);
        }

        $this->db->exec("UPDATE {$this->table} SET {$this->treeLeft} = {$parentId}, {$this->treeRight} = {$right} WHERE ($this->primaryKey) = {$left}");

        return $right + 1;
    }

    protected function resetTree()
    {
        $this->db->exec("UPDATE {$this->table} SET {$this->treeLeft} = 0, {$this->treeRight} = 0");

        return true;
    }
}
