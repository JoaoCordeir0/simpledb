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
            $where = Helper::unpackWhere($this->oper->getWhere());
            $limit = Helper::unpackLimit($this->oper->getLimit());

            $query = "SELECT " . $columns . " FROM " . $this->oper->getTable() . $where . $order . $limit;
            $query = str_replace('  ', ' ', $query);
                        
            $select = $this->oper->getConn()->prepare($query);
            $select->execute();
           
            $obj = [];

            if ($select->rowCount() > 1)
                $obj = $select->fetchAll(\PDO::FETCH_ASSOC);    
            else if ($select->rowCount() == 1) 
                $obj = $select->fetch(\PDO::FETCH_ASSOC);         
            
            if ($this->oper->getDebug())
                array_push($obj, ['Debug' => ['Query' => $query]]);

            return (object) $obj;
        }
        catch (Exception $e)
        {
            return [
                'Error' => $e->getMessage(),
                'Debug' =>[
                    'Query' => $query
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
        }
        catch (Exception $e)
        {
            return [
                'Error' => $e->getMessage(),
                'Debug' =>[
                    'Query' => $query
                ]
            ];   
        }
    }      

    public function updateDB() 
    {
        echo "Linha atualizada na tabela -> " . $this->oper->getTable() . PHP_EOL;
    } 

    public function deleteDB() 
    {
        echo "Linha deletada na tabela -> " . $this->oper->getTable() . PHP_EOL;
    }     
}

