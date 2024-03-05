<?php 

namespace SimpleDB;

interface Base 
{        
    public function operation($operation);
    public function data($data);
    public function save(): bool;
}