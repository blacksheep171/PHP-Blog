<?php 
namespace App\Models;

use App\Core\Model as Model;
class Post extends Model{

    private $db_table = "posts";

    public $id;
    public $title;
    public $summary;
    public $content;
    public $user_id;
    public $created_at;
    public $updated_at;

    
    // Get all posts
    public function index(){
        $sql = "SELECT `id`, `title`,`summary`, `content`, `created_at`, `updated_at` FROM " . $this->db_table . "";
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

    // Create specific post
    public function create($title,$slug, $summary,$content,$user_id,$created_at,$updated_at){
        $sql = "INSERT INTO " . $this->db_table . " (`title`, `slug`, `summary`, `content`, `user_id`, `created_at`, `updated_at`) VALUES (:title, :slug, :summary, :content, :user_id, :created_at, :updated_at)";
        $this->db->query($sql);
        $this->db->bind(':title', $title);
        $this->db->bind(':slug', $slug);
        $this->db->bind(':summary', $summary);
        $this->db->bind(':content', $content);
        $this->db->bind(':user_id',$user_id);
        $this->db->bind(':created_at',$created_at);
        $this->db->bind(':updated_at',$updated_at);

        if($this->db->execute()){
            $insert_id = $this->db->lastInsertId();
            $data = $this->get($insert_id);
            return $data;
        } else {
            return false;
        }
    }

    // Get specific post
     public function get($id) {
        $sql = "SELECT `id`, `title`, `summary`, `content`, `user_id`, `created_at`, `updated_at` FROM " . $this->db_table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    // Update the specific post
    public function update($id,$title, $slug,$summary,$content, $user_id, $updated_at){
        $sql = "UPDATE " . $this->db_table . " SET `title` = :title, `slug` = :slug, `summary` = :summary, `content` = :content, `user_id` = :user_id, `updated_at` = :updated_at WHERE `id` = :id "; 
        $this->db->query($sql);
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
            $data = $this->get($id);
            return $data;
        } else {
            return null;
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
