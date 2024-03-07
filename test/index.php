<?php

include "../vendor/autoload.php";

use SimpleDB\Connection;
use SimpleDB\Opers;

class User extends Opers {
    
    private $table = 'users';
    private $columns = [     
        'nome:varchar(255):not null', 
        'email:varchar(255):',
        'status:int:not null'
    ];

    public function __construct() {        
        parent::__construct($this->table, $this->columns);
    }   
}

// new SimpleDB\Info(); // Show php info

// $conn = new Connection();
// $conn->conn();

// $user = new User();
// $user->data(['nome' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com', 'status' => 1])
//      ->insert();

// $user = new User;
// $user->where(['id', 1])     
//      ->like(['nome', 'cordeiro'])
//      ->limit(10)
//      ->select(); // SELECT id, nome, email FROM users WHERE id = "1" AND nome LIKE "%cordeiro%" LIMIT 10

// print_r($user->result()); // Object()

$user = new User;
$user->columns(['id', 'nome', 'email'])     
     ->select(); // SELECT id, nome, email FROM users WHERE id = "1" AND nome LIKE "%cordeiro%" LIMIT 10

print_r($user->result()); // Object()