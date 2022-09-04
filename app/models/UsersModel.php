<?php

class UsersModel
{   
    // Connection
    private $db;
    private $db_table = "users";
    // Columns
    public $id;
    public $fullname;
    public $email;
    public $password;
    public $gender;
    public $avatar;
    public $created_at;
    public $updated_at;
    // Db connection
    public function __construct(){
        $this->db = new Database;
    }
    public function findBySql($query){
        $this->db->query($query);

        $set = $this->db->resultSet();

        return $set;
    }
    public function getName(){
        return "Hieu lam het";
    }
    function tong($x, $y)
    {
        return $x + $y;
    }
    
    // Get all user
    public function getUsers(){
        $query = "SELECT id, fullname, email, gender, avatar, created_at, updated_at FROM " . $this->db_table . "";
        $data = $this->findBySql($query);
        
        return $data;
    }
}
?>