<?php

namespace App\Models\Repository;

use App\Core\Database;
use App\Models\Comment as Comment;
use App\Helpers\Log as Log;
use PDO;
use Exception;

class CommentRepository extends Comment {
    public $db;
    
    public function __construct(){
        $this->db = Database::connect();
    }

    public function create($input) {
        try {
            $sql = "INSERT INTO " . $this->table . " (`comment`, `reply`,`user_id`,`post_id`,`created_at`,`updated_at`) VALUES (:comment, :reply,:user_id,:post_id,:created_at,:updated_at)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':comment' => $input->getComment(),
                ':reply' => $input->getReply(),
                ':user_id' => $input->getUserId(),
                ':post_id' => $input->getPostId(),
                ':created_at' => $input->getCreatedAt(),
                ':updated_at' => $input->getUpdatedAt()
            ];
            if($stmt->execute($data)){
                $id = $this->db->lastInsertId();
                $result = $this->get($id);
                if(!empty($result)){
                    return $result;
                } else {
                    return [];
                }
            } else {
                return [];
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return [];
        }
    }

    public function index(){
        try {
            $sql = "SELECT * FROM ".$this->table;
            $stmt = $this->db->prepare($sql);
            
            if($stmt->execute()){
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } else {
                return [];
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return [];
        }
    }

    public function get($id) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE `id` = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $data = [
                'id' => $id
            ];
            if($stmt->execute($data)){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return [];
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return [];
        }
    }

    public function update($input) {
        try {
            $sql = "UPDATE " . $this->table . " SET `comment` = :comment, `reply` = :reply, `user_id` = :user_id, `post_id` = :post_id, `updated_at` = :updated_at WHERE `id` = :id "; 
            $stmt = $this->db->prepare($sql);
            $data = [
                ':comment' => $input->getComment(),
                ':reply' => $input->getReply(),
                ':user_id' => $input->getUserId(),
                ':post_id' => $input->getPostId(),
                ':updated_at' => $input->getUpdatedAt(),
                ':id' => $input->getId(),
            ];
            if($stmt->execute($data)){
                $result = $this->get($input->getId());
                if(!empty($result)){
                    return $result;
                } else {
                    return [];
                }
            } else {
                return [];
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return [];
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE `id` = :id ";
            $stmt = $this->db->prepare($sql);
            $data = [
                'id' => $id
            ];
            if($stmt->execute($data)){
                return null;
            } else {
                return null;
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return null;
        }
    }
}
