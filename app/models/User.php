<?php
namespace App\Models;

use App\Core\Model as Model;

class User extends Model
{   
    // Declare table
    private $table = "users";
    // Columns
    public $id;
    public $full_name;
    public $email;
    public $password;
    public $gender;
    public $avatar;
    public $created_at;
    public $updated_at;

    // Find current data by id
    public function find($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single($sql); 
        return $data;
    }

    // Get all users
    public function index(){
        $sql = "SELECT `id`, `full_name`, `email`, `gender`, `avatar`, `created_at`, `updated_at` FROM " . $this->table . "";
        $data = $this->findAll($sql);
        return $data;
    }

    // Create new specific users
    public function create($full_name, $email,$password,$gender, $avatar, $created_at, $updated_at){
        $sql = "INSERT INTO " . $this->table . " (`full_name`, `email`,`password`, `gender`, `avatar`, `created_at`, `updated_at`) VALUES (:full_name, :email, :password, :gender, :avatar , :created_at, :updated_at)";
        $this->db->query($sql);
        $this->db->bind(':full_name', $full_name);
        $this->db->bind(':email',$email);
        $this->db->bind(':password',$password);
        $this->db->bind(':gender',$gender);
        $this->db->bind(':avatar',$avatar);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            $insert_id = $this->db->lastInsertId();
            $data = $this->get($insert_id);
            return $data;
        } else {
            return null;
        }
    }

    // Get specific user
    public function get($id) {
        $sql = "SELECT `id`, `full_name`, `email`, `gender`, `avatar`, `created_at`, `updated_at` FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    // Update the specific user
    public function update($id, $full_name, $email, $gender, $avatar, $updated_at){
        $sql = "UPDATE " . $this->table . " SET `full_name` = :full_name, `email` = :email, `gender` = :gender, `avatar` = :avatar, `updated_at` = :updated_at WHERE `id` = :id "; 
        $this->db->query($sql);
        $this->db->bind(':id',$id);

        if($full_name != ""){
            $this->db->bind(':full_name', $full_name);
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
            $data = $this->get($id);
            return $data;
        } else {
            return null;
        } 
    }

    // Delete the specific user
    public function delete($id) {    
        $sql = "DELETE FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();

        return $data;
    }

    // Change user password
    public function changePassword($id, $password){
        $sql = "UPDATE ". $this->table ." SET `password` = :password WHERE `id` = :id";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        if($password !== ''){
            $this->db->bind(':password',$password);
        }
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
?>
