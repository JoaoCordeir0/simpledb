<?php 

namespace SimpleDB;

interface Base 
{        
    public function operation($operation);
    public function data(array $data);
    public function result();
    public function limit(int $limit);
    public function where(array $where);
    public function orWhere(array $orwhere);
    public function like(array $like);
    public function orderAsc(string $col = 'id');
    public function orderDesc(string $col = 'id');
    public function save();
    public function search();
}