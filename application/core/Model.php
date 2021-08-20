<?php

class Model
{
    /** @var Db $db */
    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }
}