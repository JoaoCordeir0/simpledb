<?php 

namespace SimpleDB;

interface Base 
{        
    public function data(array $data);
    public function columns(array $columns);
    public function where(array $where);
    public function orWhere(array $orwhere);
    public function like(array $like);
    public function limit(int $limit);
    public function orderAsc(string $col = 'id');
    public function orderDesc(string $col = 'id');
    public function getTable();
    public function getColumns();
    public function getConn();
    public function getData();
    public function getWhere();
    public function getOrWhere();
    public function getLike();
    public function getLimit();
    public function getOrderAsc();
    public function getOrderDesc();
    public function result();
    public function insert();
    public function select();
    public function update();
    public function delete();
}