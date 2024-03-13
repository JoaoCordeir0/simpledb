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
    
    public function selectDB() 
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

            if ($rowCount > 1)
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
            print_r((object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' => [
                    'query' => $query
                ]
            ]);         

            return null;
        }              
    } 

    public function insertDB() 
    {
        try 
        {            
            $interrogation = substr(str_repeat('?,', count($this->oper->getColumns())), 0, -1); 
            $columns = Helper::unpackColumns($this->oper->getColumns(), 'insert');            

            $query = "INSERT INTO " . $this->oper->getTable() . " (" . $columns . ") VALUES (" . $interrogation . ")";       

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
                'debug' => [
                    'query' => $query
                ]
            ];
        }
        catch (Exception $e)
        {
            print_r((object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' =>[
                    'query' => $query
                ]
            ]);    

            return null;
        }
    }      

    public function updateDB() 
    {
        echo "Linha atualizada na tabela -> " . $this->oper->getTable() . PHP_EOL;
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
            print_r((object) [
                'status' => 'error',
                'message' => $e->getMessage(),                
                'debug' =>[
                    'query' => $query
                ]
            ]);    

            return null;
        }
    }     
}

