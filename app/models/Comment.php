<?php 

class Comment {

    private $db_table = "comments";

    public $id;
    public $comment;
    public $reply;
    public $user_id;
    public $post_id;
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

    // Get all comments
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

    // Create new comment
    public function create($comment, $reply, $user_id, $post_id, $created_at, $updated_at){
        $query = "INSERT INTO " . $this->db_table . " (`comment`, `reply`,`user_id`,`post_id`,`created_at`,`updated_at`  ) VALUES (:comment, :reply,:user_id,:post_id,:created_at,:updated_at)";
        $this->db->query($query);               
        $this->db->bind(':comment', $comment);
        $this->db->bind(':reply', $reply);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':created_at', $created_at);
        $this->db->bind(':updated_at', $updated_at);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    
    // Get the specific comment
    public function get($id) {
        $query = "SELECT `comment`,`reply`,`user_id`,`post_id`,`created_at`,`updated_at` FROM " . $this->db_table . " WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        $data = $this->db->single();
        return $data;
    }
    
    // Update the specific comment
    public function update($id, $comment, $reply, $user_id, $post_id, $updated_at){
        $query = "UPDATE " . $this->db_table . " SET `comment` = :comment, `reply` = :reply, `user_id` = :user_id, `post_id` = :post_id WHERE `id` = :id";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':post_id',$post_id);

        if($comment != ""){
            $this->db->bind(':comment', $comment);
        }
        if($reply != ""){
            $this->db->bind(':reply',$reply);
        }
        if($updated_at != ""){
            $this->db->bind(':updated_at',$updated_at);
        }

        if($this->db->execute()){
            return true;
        } else {
            return false;
        } 
    }

    // Delete the specific comment
    public function delete($id) {
        $query = "DELETE FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($query);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}
