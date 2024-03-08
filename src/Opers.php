<?php 

namespace SimpleDB;

use SimpleDB\Interface\InterfaceOpers;

class Opers implements InterfaceOpers
{       
    private $db;
    private $table;
    private $columns;
    private $data;
    private $where;    
    private $limit;
    private $debug;
    private $orderby;    
    private $result;       

    public function __construct($table, $columns, $data = [], $where = '', $debug = false, $orderby = '', $limit = 0)
    {           
        $this->db = new Connection();     
        $this->table = $table;
        $this->columns = $columns;
        $this->data = $data;                     
        $this->where = $where;
        $this->orderby = $orderby;        
        $this->limit = $limit;        
        $this->debug = $debug;        

        new Helper($table, $columns, $this->db->conn());    
    }  

    /**
     * Opers
     */       
    public function get() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $this->result = $crud->selectDB();
    }

    public function insert() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $crud->insertDB();
    }

    public function update() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $crud->updateDB();
    }

    public function delete() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $crud->deleteDB();
    }

    /**
     * Setters
     */
    public function select(array $columns = []) 
    {        
        if (! empty($columns))        
            $this->columns = $columns;
        return $this;
    }

    public function data(array $data) 
    {
        $this->data = $data;
        return $this;
    }
        
    public function where(string $where) 
    {
        $this->where = $where;
        return $this;
    }   

    public function limit(int $limit) 
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderby(string $col = 'id', string $action = 'ASC') 
    {
        $this->orderby = $col . ':' . $action;
        return $this;
    }    

    public function debug(bool $debug) 
    {
        $this->debug = $debug;
        return $this;
    }

    /**
     * Getters
     */
    public function getTable() { return $this->table; }
    
    public function getColumns() { return $this->columns; }
    
    public function getConn() { return $this->db->conn(); }
    
    public function getData() { return $this->data; }

    public function getWhere() { return $this->where; }

    public function getLimit() { return $this->limit; }

    public function getDebug() { return $this->debug; }

    public function getOrderBy() { return $this->orderby; }    

    public function result() { return $this->result; }
}