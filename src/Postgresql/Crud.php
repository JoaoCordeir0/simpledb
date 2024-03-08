<?php 

namespace SimpleDB\Postgresql;

use Exception;
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
        echo "Em dev";
    } 

    public function insertDB() 
    {
        echo "Em dev";
    }      

    public function updateDB() 
    {
        echo "Em dev";
    } 

    public function deleteDB() 
    {
        echo "Em dev";
    }     
}

