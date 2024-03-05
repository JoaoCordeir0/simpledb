<?php 

namespace SimpleDB;

use Exception;

class Opers extends CRUD implements \SimpleDB\Base{

    private $table;
    private $columns;
    private $operation;
    private $data = [];

    public function __construct($table, $columns)
    {   
        $this->table = $table;
        $this->columns = $columns;
    }  

    public function operation($operation) {
        $this->operation = $operation;
    }

    public function data($data) {
        $this->data = $data;
    }

    public function save(): bool{
        
        if (!isset($this->operation) || empty($this->operation)) 
            throw new Exception('Operation not informed');
        
        parent::__construct($this->table, $this->columns, $this->data);

        try
        {
            switch($this->operation) {
                case 'insert':
                    parent::insert();
                    break;
                case 'select':
                    parent::select();
                    break;
                case 'delete':
                    parent::delete();
                    break;
                case 'update':
                    parent::update();
                    break;
            }     
            return true;
        }
        catch(Exception)
        {
            return false;
        }            
    }    
}