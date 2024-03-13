# How to use:

_> composer require simpledb/simpledb

### In php: 

###### Set table: 

```php
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
```

###### Comands with table:

###### Insert -> 

```php
    $user = new User();
    $user->data(['nome' => 'João Victor Cordeiro', 'email' => 'joaocordeiro2134@gmail.com', 'status' => 1])
         ->insert();
```


###### Select -> 

```php
    $user = new User;
    $user->select(['id', 'nome', 'email'])  
         ->innerjoin('user_lvl on user_lvl.id = users.lvl')
         ->where('nome like "%cordeiro%"')       
         ->orderby()             
         ->limit(1)          
         ->get(); // SELECT id, nome, email FROM users INNER JOIN user_lvl on user_lvl.id = users.lvl WHERE nome like "%cordeiro%" ORDER BY id ASC LIMIT 1

    print_r($user->result()); // Object()
```


###### Delete -> 

```php
    $id = 5;
    $user = new User();
    $user->where("id = {$id}")
         ->debug(true)
         ->delete(); // "DELETE FROM users WHERE id = 5"
```