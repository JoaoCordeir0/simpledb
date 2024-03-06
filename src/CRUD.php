<?php 

namespace SimpleDB;

class CRUD {
 
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

    public function __construct($table, $columns, $data = [], $where = [], $orwhere = [], $like = [], $orderasc = '', $orderdesc = '', $limit = 0)
    {
        $this->conn = (new Connection('Dev'))->conn();
        $this->table = $table;
        $this->columns = $columns;
        $this->data = $data;
        $this->where = $where;
        $this->orwhere = $orwhere;
        $this->like = $like;
        $this->limit = $limit;

        new Helper($table, $columns, $this->conn);    
    }

    public function setData(array $data) {
        $this->data = $data;
    }

    public function setWhere(array $where) {
        $this->where = $where;
    }

    public function setOrWhere(array $orwhere) {
        $this->orwhere = $orwhere;
    }

    public function setLimit(int $limit) {
        $this->limit = $limit;
    }

    public function setLike(array $like) {
        $this->like = $like;
    }

    public function setOrderAsc(string $col) {
        $this->orderasc = $col;
    }

    public function setOrderDesc(string $col) {
        $this->orderdesc = $col;
    }

    public function insert() 
    {
        $interrogation = substr(str_repeat('?,', count($this->columns)), 0, -1); ;        

        $query = "INSERT INTO " . $this->table . " (" . Helper::unpackColumns($this->columns) . ") VALUES (" . $interrogation . ")";       
        
        $insert = $this->conn->prepare($query);        

        $c = 1;
        foreach ($this->columns as $column) 
        {
            $col = explode(':', $column);            
            $insert->bindParam($c, $this->data[$col[0]], $col[2] == 'int' ? \PDO::PARAM_INT : \PDO::PARAM_STR);                
            $c++;
        }        
        $insert->execute();
    }      

    public function update() 
    {
        echo "Linha inserida na tabela -> " . $this->table . PHP_EOL;
    } 

    public function delete() 
    {
        echo "Linha deletada na tabela -> " . $this->table . PHP_EOL;
    } 

    public function select() 
    {   
        $orderasc = strlen($this->orderasc) > 0 ? ' ORDER BY ' . $this->orderasc . ' ASC' : '';     
        $orderdesc = strlen($this->orderdesc) > 0 ? ' ORDER BY ' . $this->orderdesc . ' DESC' : '';     
        $order = $orderasc . $orderdesc;

        $query = "SELECT id, " . Helper::unpackColumns($this->columns) . " FROM " . $this->table . Helper::unpackWhere($this->where, $this->orwhere, $this->like) . $order . Helper::unpackLimit($this->limit);
        $query = str_replace('  ', ' ', $query);
        
        // print($query . PHP_EOL);
        
        $select = $this->conn->prepare($query);
        $select->execute();
        return (object) $select->fetchAll(\PDO::FETCH_ASSOC);            
    } 
}

