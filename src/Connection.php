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
        self::setProperties($mode);

        switch($this->bank) {
            case 'mysql':                
                $this->setConnMysql();
                break;
            case 'sqlserver':
                $this->setConnSqlserver();
                break;
        }
    }

    public function setConnMysql() 
    {
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

    public function setConnSqlserver() 
    {
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

    public function setConnPostgresql() 
    {
        print 'Em dev';                
    }
    
    public function setProperties($mode) 
    {
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
                switch($splitrow[0])
                {
                    case 'bank': 
                        $this->bank = trim($splitrow[1]);
                        break;
                    case 'host':
                        $this->host = trim($splitrow[1]);
                        break;
                    case 'db':
                        $this->db = trim($splitrow[1]);
                        break;
                    case 'uid':
                        $this->uid = trim($splitrow[1]);
                        break;
                    case 'pwd':
                        $this->pwd = trim($splitrow[1]);
                        break;
                }                    
            }                
            fclose($file);
        } else {            
            throw new Exception('Unable to open or locate database.db');
        }
    }

    public function conn() { return $this->conn; }

    public function bank() { return $this->bank; }
}