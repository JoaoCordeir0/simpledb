<?php 

namespace SimpleDB;

use PDOException;
use PDO;

class Connection {

    private $servername;
    private $username;
    private $password;
    private $dbname; 
    private $conn;

    public function __construct($servername, $dbname, $username, $password, $bank) 
    {
        $this->servername = $servername;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;            

        switch($bank) {
            case 'mysql':
                $this->setConnMysql();
                break;
            case 'sqlserver':
                $this->setConnSqlserver();
                break;
        }
    }

    public function setConnMysql() {
        try 
        {
            $servername = $this->servername;
            $dbname = $this->dbname;
            $db = new PDO("mysql:host=$servername;dbname=$dbname", $this->username, $this->password);            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            
            $this->conn = $db;

            print 'Connection OK' . PHP_EOL;
        } 
        catch(PDOException $e) 
        {
            print 'Mysql - Connection failed: ' . $e->getMessage();
        }
    }

    public function setConnSqlserver() {
        try 
        {
            $serverName = $this->servername;
            $dataBase = $this->dbname;                                                            
            $db = new PDO("sqlsrv:server=$serverName; Database=$dataBase", $this->username, $this->password);    
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn = $db;

            print 'Connection OK' . PHP_EOL;
        } 
        catch (PDOException $e) 
        {                            
            print 'Sqlserver - Connection failed: ' . $e->getMessage();
        }                    
    }

    public function conn() {
        return $this->conn;
    }
}