<?php 

namespace SimpleDB\Interface;

interface InterfaceCrud
{   
    /**
     * Functions 
     */
    public function selectDB(bool $object);
    public function insertDB();
    public function updateDB();
    public function deleteDB();
}        
   

    