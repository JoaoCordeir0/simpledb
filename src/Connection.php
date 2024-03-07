<?php 

namespace SimpleDB;

use Exception;
use PDOException;
use PDO;

class Connection {

    private $bank;
    private $host;
    private $uid;
    private $pwd;
    private $db; 
    private $conn;

    public function __construct($mode = 'Prod') 
    {     
        self::setVariables($mode);

        switch($this->bank) {
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
            $host = $this->host;
            $dbname = $this->db;
            $db = new PDO("mysql:host=$host;dbname=$dbname", $this->uid, $this->pwd);            
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   

            $this->conn = $db;

            // print 'Mysql - Connection OK' . PHP_EOL;
        } 
        catch(PDOException $e) 
        {
            print 'Mysql - Connection failed: ' . $e->getMessage();
        }
    }

    public function setConnSqlserver() {
        try 
        {
            $host = $this->host;
            $dbname = $this->db;                                                            
            $db = new PDO("sqlsrv:server=$host; Database=$dbname", $this->uid, $this->pwd);    
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn = $db;

            // print 'Sqlserver - Connection OK' . PHP_EOL;
        } 
        catch (PDOException $e) 
        {                            
            print 'Sqlserver - Connection failed: ' . $e->getMessage();
        }                    
    }

    public function conn() {
        return $this->conn;
    }

    public function setVariables($mode) {
        $dir_file = '';
        
        switch($mode) {
            case 'Prod': 
                $dir_file = dirname(dirname(dirname(dirname(__DIR__)))) . '/database.db'; 
                break;
            case 'Dev': 
                $dir_file = dirname(__DIR__) . '/database.db'; 
                break;
        }
       
        $file = fopen($dir_file, 'r');
       
        if ($file) {          
            for ($row = fgets($file); $row !== false; $row = fgets($file)) {                
                $splitrow = explode('=', $row);
                if ($splitrow[0] == 'bank')
                    $this->bank = trim($splitrow[1]);
                if ($splitrow[0] == 'host')
                    $this->host = trim($splitrow[1]);
                if ($splitrow[0] == 'db')
                    $this->db = trim($splitrow[1]);
                if ($splitrow[0] == 'uid')
                    $this->uid = trim($splitrow[1]);
                if ($splitrow[0] == 'pwd')
                    $this->pwd = trim($splitrow[1]);
            }                
            fclose($file);
        } else {            
            throw new Exception('Unable to open or locate database.db');
        }
    }
}