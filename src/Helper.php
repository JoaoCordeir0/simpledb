<?php 

namespace SimpleDB;

class Helper {
 
    private $conn;
    private $table;
    private $columns;   

    public function __construct($table, $columns, $conn, $checktable)
    {
        $this->table = $table;
        $this->columns = $columns;        
        $this->conn = $conn;        

        if ($checktable) {
            self::checkTableExists();          
        }            
    }

    public static function getCrudInstance($bank, $obj)
    {
        switch($bank)
        {
            case 'mysql':
                return new Mysql\Crud($obj);
                break;
            case 'sqlserver': 
                return new Sqlserver\Crud($obj);
                break;
        }
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

    public static function unpackColumns(array $columns, string $action = 'select') 
    {        
        $flagSingleColumns = false;
        $strColumns = '';        
        foreach ($columns as $column) {
            if (stripos($column, ':') !== false) {
                if ($action == 'update') {
                    $exp = explode(':', $column);
                    $strColumns .= $exp[0] . ' = ?, ';
                    $flagSingleColumns = true;
                } else {
                    $exp = explode(':', $column);
                    $strColumns .= $exp[0] . ', ';                
                }                
            } else {
                $strColumns .= $column . ', ';
                $flagSingleColumns = true;
            }            
        }

        if ($action != 'select' || $flagSingleColumns)            
            return substr($strColumns, 0, -2);        
        return 'id, ' . substr($strColumns, 0, -2) . ', created_at';   
    }

    public static function unpackLimit(int $limit) 
    {
        if ($limit == 0) {
            return '';
        }     
        return ' LIMIT ' . $limit;
    }

    public static function unpackOrderBy(string $order) 
    {
        if (! stripos($order, ':') !== false) {
            return '';
        }                 
        $exp = explode(':', $order);
        return ' ORDER BY ' . $exp[0] . ' ' . $exp[1];
    }

    public static function unpackWhere($where) 
    {            
        if (strlen($where) < 2) {
            return '';
        }

        $where = ' WHERE ' . $where; 
        
        return $where;       
    }     
    
    public static function unpackJoin($inner = '', $left = '', $right = '') 
    {                      
        $join = '';
 
        if (strlen($inner) > 3) {            
            foreach (explode(':', $inner) as $i)
            {
                $join .= ' INNER JOIN ' . $i;
            }
        }
        if (strlen($left) > 3) {            
            foreach (explode(':', $left) as $l)
            {
                $join .= ' LEFT JOIN ' . $l;
            }
        }
        if (strlen($right) > 3) {            
            foreach (explode(':', $right) as $r)
            {
                $join .= ' RIGHT JOIN ' . $r;
            }
        }
                
        return $join;
    }    
}

