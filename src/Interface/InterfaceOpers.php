<?php 

namespace SimpleDB\Interface;

interface InterfaceOpers
{   
    /**
     * Operators 
     */
    public function get();
    public function insert();
    public function update();
    public function delete();

    /**
     * Setters
     */    
    public function select(array $columns = []);
    public function data(array $data);
    public function where(string $where);
    public function limit(int $limit);
    public function orderby(string $col = 'id', string $action = 'ASC');
    public function innerjoin(string $innerjoin);
    public function leftjoin(string $leftjoin);
    public function rightjoin(string $rightjoin);
    public function debug(bool $debug);

    /**
     * Getters
     */
    public function getTable();
    public function getColumns();
    public function getConn();
    public function getData();
    public function getWhere();
    public function getLimit();
    public function getDebug();
    public function getOrderBy();
    public function getInnerJoin();
    public function getLeftJoin();
    public function getRightJoin();
    public function result();
}        
   

    