<?php 

namespace SimpleDB;

use Exception;

class Opers extends CRUD implements \SimpleDB\Base{
    
    private $operation; 
    private $result;   

    public function __construct($table, $columns)
    {           
        parent::__construct($table, $columns);
    }  

    public function operation($operation) {
        $this->operation = $operation;
        return $this;
    }

    public function result() {      
        return $this->result;
    }

    public function data(array $data) {
        parent::setData($data);
        return $this;
    }

    public function where(array $where) {
        parent::setWhere($where);
        return $this;
    }

    public function orWhere(array $where) {
        parent::setOrWhere($where);
        return $this;
    }

    public function like(array $like) {
        parent::setLike($like);
        return $this;
    }

    public function limit(int $limit) {
        parent::setLimit($limit);
        return $this;
    }

    public function orderAsc(string $col = 'id') {
        parent::setOrderAsc($col);
        return $this;
    }

    public function orderDesc(string $col = 'id') {
        parent::setOrderDesc($col);
        return $this;
    }

    public function save() {        
        if (!isset($this->operation) || empty($this->operation)) 
            throw new Exception('Operation not informed');    

        try
        {
            switch($this->operation) {
                case 'insert':
                    parent::insert();
                    break;                
                case 'delete':
                    parent::delete();
                    break;
                case 'update':
                    parent::update();
                    break;
            }                 
        }
        catch(Exception $e)
        {
            print $e->getMessage();
        }         
    }    

    public function search() {        
        try
        {           
            $this->result = parent::select();  
            return $this;
        }
        catch(Exception $e)
        {
            print $e->getMessage();
        }   
    }
}