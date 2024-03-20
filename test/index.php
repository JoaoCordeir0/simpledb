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
        parent::__construct($this->table, $this->columns, false);
    }   
}

// new SimpleDB\Info(); // Show php info

// $conn = new Connection();
// $conn->conn();

$user = new User();
$user->data(['nome' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com', 'status' => 1])
     ->insert();

print_r($user->result()->returnid);

// print $user->result()->status;

// $user = new User;
// $user->select(['id', 'nome', 'email'])  
//      ->innerjoin('user_lvl on user_lvl.id = users.lvl')
//      ->where('nome like "%cordeiro%"')       
//      ->orderby()             
//      ->limit(1)   
//      ->debug(true)
//      ->get(); // SELECT id, nome, email FROM users INNER JOIN user_lvl on user_lvl.id = users.lvl WHERE nome like "%cordeiro%" ORDER BY id ASC LIMIT 1

// print_r($user->result()); // Object()


// $user = new User;
// $user->select()                   
//      ->get($object = true);

// print_r($user->result()); // Object()
// print_r($user->debug()); // Object()


// $id = 5;
// $user = new User();
// $user->where("id = {$id}")    
//      ->delete();

// var_dump($user->result());

// $id = 3;
// $user = new User();
// $user->data(['nome' => 'João Cordeiro', 'email' => 'jvc2134@gmail.com', 'status' => 1])
//      ->where("id = {$id}")    
//      ->update();

// var_dump($user->result());