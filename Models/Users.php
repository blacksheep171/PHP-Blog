<?php

class Users
{
    // Connection
    private $conn;
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
    public function __construct($db){
        $this->conn = $db;
    }
    // Get all user
    public function getUsers(){
        $query = "SELECT id, fullname, email, gender, avatar, created_at, updated_at FROM " . $this->db_table . "";
        $data = $this->conn->prepare($query);
        $data->execute();
        return $data;
    }
    // create user
    public function createUsers(){
        $query = "INSERT INTO ". $this->db_table ."
            SET
                fullname = :fullname, 
                email = :email,
                password = :password,
                gender = :gender, 
                avatar = :avatar, 
                created_at = :created_at,
                updated_at = :updated_at";
    
        $data = $this->conn->prepare($query);
    
        // sanitize
        $this->fullname=htmlspecialchars(strip_tags($this->fullname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->avatar=htmlspecialchars(strip_tags($this->avatar));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
        $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));
    
        // bind data
        $data->bindParam(":fullname", $this->fullname);
        $data->bindParam(":email", $this->email);
        $data->bindParam(":password", $this->password);
        $data->bindParam(":gender", $this->gender);
        $data->bindParam(":avatar", $this->avatar);
        $data->bindParam(":created_at", $this->created_at);
        $data->bindParam(":updated_at", $this->updated_at);
    
        if($data->execute()){
            return true;
        }
        return false;
    }
    // get specific user
    public function getUser(){
        $query = "SELECT
                    id, 
                    fullname, 
                    email, 
                    gender, 
                    avatar, 
                    created_at,
                    updated_at
                  FROM ". $this->db_table ."
                WHERE 
                id = ?
                LIMIT 0,1";
        $data = $this->conn->prepare($query);
        $data->bindParam(1, $this->id);
        $data->execute();
        $dataRow = $data->fetch(PDO::FETCH_ASSOC);
        
        $this->fullname = $dataRow['fullname'] ?? null;
        $this->email = $dataRow['email'] ?? null;
        $this->gender = $dataRow['gender'] ?? null;
        $this->avatar = $dataRow['avatar'] ?? null;
        $this->created_at = $dataRow['created_at']  ?? null;
        $this->updated_at = $dataRow['updated_at']  ?? null;
    }        
    // update user
    public function updateUsers(){
        $query = "UPDATE ". $this->db_table ."
                SET
                    fullname = :fullname, 
                    email = :email, 
                    password = :password, 
                    gender = :gender, 
                    avatar = :avatar,
                    updated_at = :updated_at
                WHERE 
                    id = :id";
    
        $data = $this->conn->prepare($query);
    
        $this->fullname=htmlspecialchars(strip_tags($this->fullname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->gender=htmlspecialchars(strip_tags($this->gender));
        $this->avatar=htmlspecialchars(strip_tags($this->avatar));
        $this->updated_at=htmlspecialchars(strip_tags($this->updated_at));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind data
        $data->bindParam(":fullname", $this->fullname);
        $data->bindParam(":email", $this->email);
        $data->bindParam(":password", $this->password);
        $data->bindParam(":gender", $this->gender);
        $data->bindParam(":avatar", $this->avatar);
        $data->bindParam(":updated_at", $this->updated_at);
        $data->bindParam(":id", $this->id);
    
        if($data->execute()){
           return true;
        }
        return false;
    }
    // delete user
    function deleteUsers(){
        $query = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $data = $this->conn->prepare($query);
    
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        $data->bindParam(1, $this->id);
    
        if($data->execute()){
            return true;
        }
        return false;
    }
}
?>