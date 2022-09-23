<?php 

class Category {

    private $db_table = "categories";

    public $id;
    public $name;
    public $slug;
  
    public function __construct(){
        $this->db = new Database;
    }

    public function findAll($query){
        $this->db->query($query);

        $set = $this->db->resultSet();

        return $set;
    }

    // Get all posts
    public function index(){
        $query = "SELECT * FROM " . $this->db_table . "";
        $data = $this->findAll($query);
        return $data;
    }

    // Find current data by id
    public function find($id) {
        $query = "SELECT * FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single($query); 
        return $data;
    }

    // Create new category
    public function create($name, $slug){
        $query = "INSERT INTO " . $this->db_table . " (`name`, `slug`) VALUES (:name, :slug)";
        $this->db->query($query);               
        $this->db->bind(':name', $name);
        $this->db->bind(':slug', $slug);
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    // Get specific category
    public function get($id) {
        $query = "SELECT * FROM " . $this->db_table . " WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $data = $this->db->single();
        return $data;
    }
    
    // Update the specific category
    public function update($id, $name, $slug){
        $query = "UPDATE " . $this->db_table . " SET `name` = :name, `slug` = :slug WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind(':id',$id);

        if($name != ""){
            $this->db->bind(':name', $name);
        }
        if($slug != ""){
            $this->db->bind(':slug',$slug);
        }

        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }

    // Delete specific post
    public function delete($id) {
        $query = "DELETE FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}
