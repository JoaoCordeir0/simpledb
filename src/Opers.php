<?php 

namespace SimpleDB;

class Opers implements Base
{   
    private $conn;
    private $table;
    private $columns;
    private $data;
    private $where;
    private $orwhere;
    private $like;
    private $limit;
    private $orderasc;
    private $orderdesc;
    private $result;   

    public function __construct($table, $columns, $data = [], $where = [], $orwhere = [], $like = [], $orderasc = '', $orderdesc = '', $limit = 0)
    {           
        $this->conn = (new Connection())->conn();
        $this->table = $table;
        $this->columns = $columns;
        $this->data = $data;
        $this->where = $where;
        $this->orwhere = $orwhere;
        $this->like = $like;
        $this->orderasc = $orderasc;
        $this->orderdesc = $orderdesc;
        $this->limit = $limit;

        new Helper($table, $columns, $this->conn);    
    }  

    public function data(array $data) 
    {
        $this->data = $data;
        return $this;
    }

    public function columns(array $columns) 
    {
        $this->columns = $columns;
        return $this;
    }
    
    public function where(array $where) 
    {
        $this->where = $where;
        return $this;
    }
   
    public function orWhere(array $orwhere) 
    {
        $this->orwhere = $orwhere;
        return $this;
    }

    public function like(array $like) 
    {
        $this->like = $like;
        return $this;
    }

    public function limit(int $limit) 
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderAsc(string $col = 'id') 
    {
        $this->orderasc = $col;
        return $this;
    }

    public function orderDesc(string $col = 'id') 
    {
        $this->orderdesc = $col;
        return $this;
    }

    public function getTable() { return $this->table; }
    
    public function getColumns() { return $this->columns; }
    
    public function getConn() { return $this->conn; }
    
    public function getData() { return $this->data; }

    public function getWhere() { return $this->where; }

    public function getOrWhere() { return $this->orwhere; }

    public function getLike() { return $this->like; }

    public function getLimit() { return $this->limit; }

    public function getOrderAsc() { return $this->orderasc; }

    public function getOrderDesc() { return $this->orderdesc; }

    public function result() { return $this->result; }

    public function insert() 
    {
        $insert = new Crud((object) $this);
        $insert->insertDB();
    }

    public function select() 
    {
        $select = new Crud((object) $this);
        $this->result = $select->selectDB();
    }

    public function update() 
    {
        $update = new Crud((object) $this);
        $update->updateDB();
    }

    public function delete() 
    {
        $delete = new Crud((object) $this);
        $delete->deleteDB();
    }
}