<?php

namespace App\Models;

use App\Database;

class Model
{
    protected Database $db;
    protected string $table;

    public function __construct(){
        $this->db = Database::getInstance();
    }

}