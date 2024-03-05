<?php

include "../vendor/autoload.php";

use SimpleDB\Connection;
use SimpleDB\Opers;

class User extends Opers {
    
    private $table = 'users';
    private $columns = [
        'id:int', 
        'nome:string', 
        'email:string'
    ];

    public function __construct() {        
        parent::__construct($this->table, $this->columns);
    }   
}

// new SimpleDB\Info(); // Show php info

$conn = new Connection('localhost', 'simpledb', 'root', '1234', 'mysql');
$conn->conn();

$user = new User();
$user->operation('insert');
$user->data(['name' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com']);
$user->save();