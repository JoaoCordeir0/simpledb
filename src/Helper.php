<?php 

namespace SimpleDB;

use Exception;

class Helper {
 
    private $conn;
    private $table;
    private $columns;   

    public function __construct($table, $columns, $conn)
    {
        $this->table = $table;
        $this->columns = $columns;        
        $this->conn = $conn;        

        self::checkTableExists();
    }

    public function checkTableExists() 
    {      
        $sql = 'SHOW TABLES LIKE "' . $this->table . '"';        
        $result = $this->conn->prepare($sql);
        $result->execute();

        if ($result->rowCount() == 0) {
            self::create();
        }
    }

    public function create() 
    {
        $columns = '';
        foreach ($this->columns as $column) {
            $exp = explode(':', $column);
            $columns .= $exp[0] . ' ' . $exp[1] . ' ' . $exp[2] . ', ';
        }

        $columns = substr($columns, 0, -2);
        $columns = str_replace(' ,', ',', $columns);

        $sql = 'CREATE TABLE IF NOT EXISTS ' . $this->table . ' (id INT AUTO_INCREMENT PRIMARY KEY, ' . $columns . ', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)';
        $create = $this->conn->prepare($sql);
        $create->execute();
    }    

    public static function unpackColumns(array $columns) 
    {
        $strColumns = '';
        foreach ($columns as $column) {
            $exp = explode(':', $column);
            $strColumns .= $exp[0] . ', ';
        }
        return substr($strColumns, 0, -2);        
    }

    public static function unpackLimit(int $limit) 
    {
        if ($limit == 0) {
            return '';
        }     
        return ' LIMIT ' . $limit;
    }

    public static function unpackWhere($where, $orwhere, $like) 
    {            
        if (count($where) > 0 && !(count($where) % 2 == 0)) {
            throw new Exception('In where, enter a column and a value.');
        }
        if (count($orwhere) > 0 && !(count($orwhere) % 2 == 0)) {
            throw new Exception('In orwhere enter a column and a value.');
        }
        if (count($like) > 0 && !(count($like) % 2 == 0)) {
            throw new Exception('In like enter a column and a value.');
        }
                
        $query = ' WHERE '; 

        if (count($where)) 
        {
            ctype_digit($where[1]) 
            ?
            $query .= $where[0] . ' = ' . $where[1]
            :
            $query .= $where[0] . ' = "' . $where[1] . '"';
        }            
        
        if (count($orwhere)) 
        {
            ctype_digit($orwhere[1]) 
            ?
            $query .= ' (' . $orwhere[0] . ' = ' . $orwhere[1] . ')'
            :
            $query .= ' (' . $orwhere[0] . ' = "' . $orwhere[1] . '")';
        }            
        
        if (count($like)) 
        {            
            strlen($query) > 7 
            ? 
            $query .= ' AND ' . $like[0] . ' LIKE "%' . $like[1] . '%" ' 
            : 
            $query .= ' ' . $like[0] . ' LIKE "%' . $like[1] . '%" ';                            
        }
            
        if (count($where) || count($orwhere) || count($like))
            return $query;
        return '';
    }    
}

