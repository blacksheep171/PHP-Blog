<?php 
namespace App\Models;

use App\Core\Model as Model;

class Comment extends Model{

    private $table = "comments";

    public $id;
    public $comment;
    public $reply;
    public $user_id;
    public $post_id;
    public $created_at;
    public $updated_at;

    // Get all comments
    public function index(){
        $sql = "SELECT * FROM " . $this->table . "";
        $data = $this->findAll($sql);
        return $data;
    }

    // Find current data by id
    public function find($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single($sql); 
        return $data;
    }

    // Create new comment
    public function create($comment, $reply, $user_id, $post_id, $created_at, $updated_at){
        $sql = "INSERT INTO " . $this->table . " (`comment`, `reply`,`user_id`,`post_id`,`created_at`,`updated_at`  ) VALUES (:comment, :reply,:user_id,:post_id,:created_at,:updated_at)";
        $this->db->query($sql);               
        $this->db->bind(':comment', $comment);
        $this->db->bind(':reply', $reply);
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':post_id', $post_id);
        $this->db->bind(':created_at', $created_at);
        $this->db->bind(':updated_at', $updated_at);

        if($this->db->execute()){
            $insert_id = $this->db->lastInsertId();
            $data = $this->get($insert_id);
            return $data;
        } else {
            return null;
        }
    }
    
    // Get the specific comment
    public function get($id) {
        $sql = "SELECT `comment`,`reply`,`user_id`,`post_id`,`created_at`,`updated_at` FROM " . $this->table . " WHERE `id` = :id";
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        $data = $this->db->single();
        return $data;
    }
    
    // Update the specific comment
    public function update($id, $comment, $reply, $user_id, $post_id, $updated_at){
        $sql = "UPDATE " . $this->table . " SET `comment` = :comment, `reply` = :reply, `user_id` = :user_id, `post_id` = :post_id, `updated_at` = :updated_at WHERE `id` = :id "; 
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':post_id',$post_id);

        if($comment != ""){
            $this->db->bind(':comment', $comment);
        }
        if($reply != ""){
            $this->db->bind(':reply',$reply);
        }
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            $data = $this->get($id);
            return $data;
        } else {
            return null;
        } 
    }

    // Delete the specific comment
    public function delete($id) {
        $sql = "DELETE FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }
}
