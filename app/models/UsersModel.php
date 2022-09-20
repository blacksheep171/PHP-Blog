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
    public function findAll($query){
        $this->db->query($query);

        $set = $this->db->resultSet();

        return $set;
    }

    // Get all users
    public function index(){
        $query = "SELECT id, fullname, email, gender, avatar, created_at, updated_at FROM " . $this->db_table . "";
        $data = $this->findAll($query);
        return $data;

    }
    public function create($fullname, $email,$password,$gender, $avatar, $created_at, $updated_at){
        $query = "INSERT INTO " . $this->db_table . " (fullname, email, password, gender, avatar, created_at, updated_at) VALUES (:fullname, :email, :password, :gender, :avatar , :created_at, :updated_at)";
        $this->db->query($query);
        $this->db->bind(':fullname', $fullname);
        $this->db->bind(':email',$email);
        $this->db->bind(':password',$password);
        $this->db->bind(':gender',$gender);
        $this->db->bind(':avatar',$avatar);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    // Get specific user
    public function getUser($id) {
        $query = "SELECT id, fullname, email, gender, avatar, created_at, updated_at FROM " . $this->db_table . " WHERE id = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    public function update($id, $fullname, $email, $gender, $avatar, $updated_at){
        $query = "UPDATE " . $this->db_table . " SET fullname = :fullname, email = :email, gender = :gender, avatar = :avatar, updated_at = :updated_at WHERE id = :id "; 
        $this->db->query($query);
        $this->db->bind(':id',$id);

        if($fullname != ""){
            $this->db->bind(':fullname', $fullname);
        }
        if($email != ""){
            $this->db->bind(':email',$email);
        }
        if($gender != ""){
            $this->db->bind(':gender',$gender);
        }
        if($avatar != ""){
            $this->db->bind(':avatar',$avatar);
        }
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }

    // delete specific user
    public function delete($id) {
        // code here        
        $query = "DELETE FROM " . $this->db_table . " WHERE id = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}
?>