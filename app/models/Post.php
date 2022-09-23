<?php 

class Post {

    private $db;
    private $db_table = "posts";

    public $id;
    public $title;
    public $summary;
    public $content;
    public $user_id;
    public $created_at;
    public $updated_at;
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
        $query = "SELECT `id`, `title`,`summary`, `content`, `created_at`, `updated_at` FROM " . $this->db_table . "";
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

    // Create specific post
    public function create($title,$slug, $summary,$content,$user_id,$created_at,$updated_at){
        $query = "INSERT INTO " . $this->db_table . " (`title`, `slug`, `summary`, `content`, `user_id`, `created_at`, `updated_at`) VALUES (:title, :slug, :summary, :content, :user_id, :created_at, :updated_at)";
        $this->db->query($query);
        $this->db->bind(':title', $title);
        $this->db->bind(':slug', $slug);
        $this->db->bind(':summary', $summary);
        $this->db->bind(':content', $content);
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    // Get specific post
     public function get($id) {
        $query = "SELECT `id`, `title`, `summary`, `content`, `user_id`, `created_at`, `updated_at` FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    // Update the specific post
    public function update($id,$title, $slug,$summary,$content, $user_id, $updated_at){
        $query = "UPDATE " . $this->db_table . " SET `title` = :title, `slug` = :slug, `summary` = :summary, `content` = :content, `user_id` = :user_id, `updated_at` = :updated_at WHERE `id` = :id "; 
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $this->db->bind(':user_id',$user_id);

        if($title != ""){
            $this->db->bind(':title', $title);
        }
        if($slug != ""){
            $this->db->bind(':slug',$slug);
        }
        if($summary != ""){
            $this->db->bind(':summary',$summary);
        }
        if($content != ""){
            $this->db->bind(':content',$content);
        }
        $this->db->bind(':updated_at',$updated_at);

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