<?php

namespace App\Core;

use PDO;
use App\Core\Database;

/**
 * Base model
 *
 */
abstract class Model
{

    /**
     * Get the PDO database connection
     *
     * @return mixed
     */
    public $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function findAll($query){
        $this->db->query($query);
        $set = $this->db->resultSet();
        return $set;
    }
    
    public function __destruct()
    {
        $this->db = null;
    }

}