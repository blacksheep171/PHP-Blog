<?php

namespace App\Models\Repository;

use App\Core\Database;
use App\Models\User as User;
use App\Helpers\Log as Log;
use PDO;
use Exception;

class UserRepository extends User {

    public $db;
    
    public function __construct(){
        $this->db = Database::connect();
    }

    public function create($input) {
        try {
            $sql = "INSERT INTO " . $this->table . " (`full_name`, `email`,`password`, `gender`, `avatar`, `created_at`, `updated_at`) VALUES (:full_name, :email, :password, :gender, :avatar , :created_at, :updated_at)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':full_name' => $input->getFullName(),
                ':email' => $input->getEmail(),
                ':password' => password_hash($input->getPassword(),PASSWORD_DEFAULT),
                ':gender' => $input->getGender(),
                ':avatar' => $input->getAvatar(),
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
            $sql = "SELECT `id`, `full_name`, `email`, `gender`, `avatar`, `created_at`, `updated_at` FROM ".$this->table;
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

    public function getUser($id) {
        try {
            $sql = "SELECT `id`, `full_name`, `email`, `gender`, `avatar`, `created_at`, `updated_at` FROM " . $this->table . " WHERE `id` = :id LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $data = [
                'id' => $id
            ];
            if($stmt->execute($data)){
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } else {
                return null;
            }
        } catch(Exception $e){
            Log::logError($e->getMessage());
            return null;
        }
    }

    public function update($input) {
        try {
            $sql = "UPDATE " . $this->table . " SET `full_name` = :full_name, `email` = :email, `gender` = :gender, `avatar` = :avatar, `updated_at` = :updated_at WHERE `id` = :id "; 
            $stmt = $this->db->prepare($sql);
            $data = [
                ':full_name' => $input->getFullName(),
                ':email' => $input->getEmail(),
                ':gender' => $input->getGender(),
                ':avatar' => $input->getAvatar(),
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

    public function login($params) {
        try {
            $sql = "SELECT * FROM " . $this->table." WHERE `email` = :email LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':email' => $params
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

    public function changePassword($input) {
        try {
            $sql = "UPDATE ". $this->table ." SET `password` = :password, `password` = :password , `updated_at` = :updated_at WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':password' => $input->getPassword(),
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
}