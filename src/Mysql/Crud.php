<?php 

namespace SimpleDB\Mysql;

use Exception;
use SimpleDB\Helper;
use SimpleDB\Interface\InterfaceCrud;

class Crud implements InterfaceCrud
{ 
    private $oper;
    
    public function __construct(object $oper)
    {
        $this->oper = $oper;       
    }
    
    public function selectDB($object) 
    {   
        try 
        {               
            $order = Helper::unpackOrderBy($this->oper->getOrderBy());
            $columns = Helper::unpackColumns($this->oper->getColumns());            
            $join = Helper::unpackJoin($this->oper->getInnerJoin(), $this->oper->getLeftJoin(), $this->oper->getRightJoin());
            $where = Helper::unpackWhere($this->oper->getWhere());
            $limit = Helper::unpackLimit($this->oper->getLimit());

            $query = "SELECT " . $columns . " FROM " . $this->oper->getTable() . $join . $where . $order . $limit;
            $query = str_replace('  ', ' ', $query);
                        
            $select = $this->oper->getConn()->prepare($query);
            $select->execute();
           
            $data = [];
            $rowCount = $select->rowCount();            

            if ($rowCount > 1 || $object)
                $data = $select->fetchAll(\PDO::FETCH_ASSOC);    
            else if ($rowCount == 1) 
                $data = $select->fetch(\PDO::FETCH_ASSOC);    

            return (object) [
                'status' => 'success',
                'data' => $data,
                'count' => $rowCount,
                'debug' => [
                    'query' => $query
                ]
            ];
        }
        catch (Exception $e)
        {     
            return (object) [
                'status' => 'error',
                'data' => [],
                'count' => 0,
                'message' => $e->getMessage(),                
                'debug' => [
                    'query' => $query
                ]
            ];                 
        }              
    } 

    public function insertDB() 
    {
        try 
        {            
            $interrogation = substr(str_repeat('?,', count($this->oper->getColumns())), 0, -1); 
            $columns = Helper::unpackColumns($this->oper->getColumns(), 'insert');            

            $query = "INSERT INTO " . $this->oper->getTable() . " ({$columns}) VALUES ({$interrogation})";       

            $insert = $this->oper->getConn()->prepare($query);                    
            $c = 1;
            foreach ($this->oper->getColumns() as $column) 
            {
                $col = explode(':', $column);            
                $insert->bindParam($c, $this->oper->getData()[$col[0]], $col[2] == 'int' ? \PDO::PARAM_INT : \PDO::PARAM_STR);                
                $c++;
            }        
            $insert->execute();

            return (object) [
                'status' => 'success',                
                'count' => $insert->rowCount(),
                'returnid' => $this->oper->getConn()->lastInsertId(),
                'debug' => [
                    'query' => $query
                ]
            ];
        }
        catch (Exception $e)
        {
            return (object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' =>[
                    'query' => $query
                ]
            ];    
        }
    }      

    public function updateDB() 
    {
        try 
        {                           
            $data = $this->oper->getData();
            $cols = $this->oper->getColumns();
            
            $columns = Helper::unpackColumns($data, 'update');
            $where = Helper::unpackWhere($this->oper->getWhere());  
                
            $query = "UPDATE " . $this->oper->getTable() . " SET " . $columns . $where;       

            $update = $this->oper->getConn()->prepare($query);                                
            $c = 1;
            foreach ($cols as $column) 
            {
                $col = explode(':', $column);                   
                if (array_key_exists($col[0], $data)) {
                    $update->bindParam($c, $data[$col[0]], $col[2] == 'int' ? \PDO::PARAM_INT : \PDO::PARAM_STR);                
                }                
                $c++;
            }             
            $update->execute();                                

            return (object) [
                'status' => 'success',                
                'count' => $update->rowCount(),
                'debug' => [
                    'query' => $query
                ]
            ];
        }
        catch (Exception $e)
        {
            return (object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' =>[
                    'query' => $query
                ]
            ];            
        }
    } 

    public function deleteDB() 
    {
        try
        {            
            $query = "DELETE FROM " . $this->oper->getTable() . Helper::unpackWhere($this->oper->getWhere()); 
                        
            $delete = $this->oper->getConn()->prepare($query);
            $delete->execute();

            return (object) [
                'status' => 'success',                
                'count' => $delete->rowCount(),
                'debug' => [
                    'query' => $query
                ]
            ];
        }
        catch (Exception $e)
        {
            return (object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' =>[
                    'query' => $query
                ]
            ];    
        }
    }     
}

