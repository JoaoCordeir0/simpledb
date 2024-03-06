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

// $conn = new Connection('Dev');
// $conn->conn();

// $user = new User();
// $user->operation('insert')
//      ->data(['nome' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com', 'status' => 1])
//      ->save();

// $user = new User();
// $user->data(['nome' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com', 'status' => 1])
//      ->insert();

// $user = new User;
// $user->where(['id', 1])     
//      ->like(['nome', 'cordeiro'])
//      ->limit(10)
//      ->search();

$user = new User;
$user->where(['status', 1])          
     ->orderDesc()
     ->search();

print_r($user->result());
