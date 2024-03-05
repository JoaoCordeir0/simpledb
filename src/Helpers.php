<?php 

namespace SimpleDB;

class Helpers {
 
    private $table;
    private $columns;   

    public function __construct($table, $columns, $data)
    {
        $this->table = $table;
        $this->columns = $columns;        
    }

    public function create() 
    {
        echo "Criando tabela -> " . $this->table . PHP_EOL;
    }  

    public function drop() 
    {
        echo "Apagando tabela -> " . $this->table . PHP_EOL;
    }     
}

