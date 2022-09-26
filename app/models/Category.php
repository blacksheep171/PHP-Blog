<?php 
namespace App\Models;

use App\Core\Model as Model;

class Category extends Model{

    private $db_table = "categories";

    public $id;
    public $name;
    public $slug;

    // Get all posts
    public function index(){
        $sql = "SELECT * FROM " . $this->db_table . "";
        $data = $this->findAll($sql);
        return $data;
    }

    // Find current data by id
    public function find($id) {
        $sql = "SELECT * FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single($sql); 
        return $data;
    }

    // Create new category
    public function create($name, $slug){
        $sql = "INSERT INTO " . $this->db_table . " (`name`, `slug`) VALUES (:name, :slug)";
        $this->db->query($sql);               
        $this->db->bind(':name', $name);
        $this->db->bind(':slug', $slug);
        if($this->db->execute()){
            $insert_id = $this->db->lastInsertId();
            $data = $this->get($insert_id);
            return $data;
        } else {
            return null;
        }
    }
    
    // Get specific category
    public function get($id) {
        $sql = "SELECT * FROM " . $this->db_table . " WHERE `id` = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $data = $this->db->single();
        return $data;
    }
    
    // Update the specific category
    public function update($id, $name, $slug){
        $sql = "UPDATE " . $this->db_table . " SET `name` = :name, `slug` = :slug WHERE `id` = :id";
        $this->db->query($sql);
        $this->db->bind(':id',$id);

        if($name != ""){
            $this->db->bind(':name', $name);
        }
        if($slug != ""){
            $this->db->bind(':slug',$slug);
        }

        if($this->db->execute()){
            $data = $this->get($id);
            return $data;
        } else {
            return false;
        } 
    }

    // Delete specific post
    public function delete($id) {
        $sql = "DELETE FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}
