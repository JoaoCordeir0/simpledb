<?php 

namespace SimpleDB;

use SimpleDB\Interface\InterfaceOpers;

class Opers implements InterfaceOpers
{       
    private $db;
    private $table;
    private $columns;
    private $data = [];
    private $where = '';    
    private $limit = 0;
    private $debug = '';
    private $orderby = '';
    private $innerjoin = '';    
    private $leftjoin = '';    
    private $rightjoin = '';    
    private $result;       
    private $count;

    public function __construct($table, $columns, $checktable = true)
    {           
        $this->db = new Connection();     
        $this->table = $table;
        $this->columns = $columns;        

        new Helper($table, $columns, $this->db->conn(), $checktable);    
    }  

    /**
     * Opers
     */       
    public function get() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $get = $crud->selectDB();            
        if ($get != null) 
        {
            $this->result = (object) $get->data;
            $this->count = $get->count;
            $this->debug = $get->debug;
        }        
    }

    public function insert() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $this->result = $crud->insertDB();        
    }

    public function update() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $this->result = $crud->updateDB();
    }

    public function delete() 
    {
        $crud = Helper::getCrudInstance($this->db->bank(), $this);
        $this->result = $crud->deleteDB();
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
        if (strlen($this->where) > 0)
            $this->where .= ' AND ' . str_replace(['and', 'AND'], '', $where);
        else
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
    
    public function innerjoin(string $innerjoin) 
    {
        if (strlen($this->innerjoin) > 0)
            $this->innerjoin .= ':' . $innerjoin;
        else
            $this->innerjoin = $innerjoin;
        return $this;        
    } 

    public function leftjoin(string $leftjoin) 
    {
        if (strlen($this->leftjoin) > 0)
            $this->leftjoin .= ':' . $leftjoin;
        else
            $this->leftjoin = $leftjoin;
        return $this; 
    } 

    public function rightjoin(string $rightjoin) 
    {
        if (strlen($this->rightjoin) > 0)
            $this->rightjoin .= ':' . $rightjoin;
        else
            $this->rightjoin = $rightjoin;
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

    public function getInnerJoin() { return $this->innerjoin; }
    
    public function getLeftJoin() { return $this->leftjoin; }

    public function getRightJoin() { return $this->rightjoin; }

    public function getOrderBy() { return $this->orderby; }    

    public function result() { return $this->result; }

    public function count() { return $this->count; }

    public function debug() { return $this->debug; }
}