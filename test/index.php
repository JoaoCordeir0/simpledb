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
// $user->select(['id', 'nome', 'email'])  
//      ->innerjoin('user_lvl on user_lvl.id = users.lvl')
//      ->where('nome like "%cordeiro%"')       
//      ->orderby()             
//      ->limit(1)   
//      ->debug(true)
//      ->get(); // SELECT id, nome, email FROM users INNER JOIN user_lvl on user_lvl.id = users.lvl WHERE nome like "%cordeiro%" ORDER BY id ASC LIMIT 1

// print_r($user->result()); // Object()


$user = new User;
$user->select()       
     ->where('nome like "%cordeiro%"')  
     ->where('status = 1')                 
     ->get(); // SELECT id, nome, email FROM users INNER JOIN user_lvl on user_lvl.id = users.lvl WHERE nome like "%cordeiro%" ORDER BY id ASC LIMIT 1

print_r($user->result()); // Object()
