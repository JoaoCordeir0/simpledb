<?php 

namespace SimpleDB;

class CRUD {
 
    private $table;
    private $columns;
    private $data;

    public function __construct($table, $columns, $data)
    {
        $this->table = $table;
        $this->columns = $columns;
        $this->data = $data;
    }

    public function insert() 
    {
        echo "Inserir na tabela -> " . $this->table . PHP_EOL;
        var_dump($this->columns);
        var_dump($this->data);
    }  

    public function select() 
    {
        echo "Linha selectionada na tabela -> " . $this->table . PHP_EOL;
    }  

    public function update() 
    {
        echo "Linha inserida na tabela -> " . $this->table . PHP_EOL;
    } 

    public function delete() 
    {
        echo "Linha deletada na tabela -> " . $this->table . PHP_EOL;
    } 
}

