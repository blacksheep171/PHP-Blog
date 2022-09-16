<?php 

class PostsModel {

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
    // Post
    public function index(){
        $query = "SELECT id, title, summary, content, created_at, updated_at FROM " . $this->db_table . "";
        $data = $this->findAll($query);
        return $data;
    }

    public function createPost($title,$slug, $summary,$content,$user_id,$created_at,$updated_at){
        $query = "INSERT INTO " . $this->db_table . " (title,slug, summary, content, user_id, created_at, updated_at) VALUES (:title, :slug, :summary, :content, :user_id, :created_at, :updated_at)";
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
     public function getPost($id) {
        $query = "SELECT id, title, summary, content, user_id, created_at, updated_at FROM " . $this->db_table . " WHERE id = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    // delete specific post
    public function deletePost($id) {
        // code here        
        $query = "DELETE FROM " . $this->db_table . " WHERE id = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}