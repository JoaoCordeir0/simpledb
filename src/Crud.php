<?php 

namespace SimpleDB;

use Exception;

class Crud 
{ 
    private $oper;
    
    public function __construct(object $oper)
    {
        $this->oper = $oper;       
    }
    
    public function insertDB() 
    {
        try 
        {
            $interrogation = substr(str_repeat('?,', count($this->oper->getColumns())), 0, -1); ;        

            $query = "INSERT INTO " . $this->oper->getTable() . " (" . Helper::unpackColumns($this->oper->getColumns()) . ") VALUES (" . $interrogation . ")";       
            
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
            print $e->getMessage();
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

    public function selectDB() 
    {   
        try 
        {
            $orderasc = strlen($this->oper->getOrderasc()) > 0 ? ' ORDER BY ' . $this->oper->getOrderasc() . ' ASC' : '';     
            $orderdesc = strlen($this->oper->getOrderdesc()) > 0 ? ' ORDER BY ' . $this->oper->getOrderdesc() . ' DESC' : '';     
            $order = $orderasc . $orderdesc;
            
            $query = "SELECT " . Helper::unpackColumns($this->oper->getColumns()) . " FROM " . $this->oper->getTable() . Helper::unpackWhere($this->oper->getWhere(), $this->oper->getOrwhere(), $this->oper->getLike()) . $order . Helper::unpackLimit($this->oper->getLimit());
            $query = str_replace('  ', ' ', $query);
            
            // print($query . PHP_EOL);
            
            $select = $this->oper->getConn()->prepare($query);
            $select->execute();
           
            $obj = [];

            if ($select->rowCount() > 1)
                $obj = $select->fetchAll(\PDO::FETCH_ASSOC);    
            else if ($select->rowCount() == 1) 
                $obj = $select->fetch(\PDO::FETCH_ASSOC);         
            
            return (object) $obj;
        }
        catch (Exception $e)
        {
            print $e->getMessage();
        }              
    } 
}

