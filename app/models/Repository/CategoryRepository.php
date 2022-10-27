<?php

namespace App\Models\Repository;

use App\Core\Database;
use App\Models\Category as Category;
use App\Helpers\Log as Log;
use PDO;
use Exception;

class CategoryRepository extends Category {

    public $db;
    
    public function __construct(){
        $this->db = Database::connect();
    }

    public function create($input) {
        try {
            $sql = "INSERT INTO " . $this->table . "(`name`, `slug`) VALUES (:name, :slug)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':name' => $input->getName(),
                ':slug' => $input->getSlug()
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
                $data = $stmt->fetchAll();
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
            $sql = "UPDATE " . $this->table . " SET `name` = :name, `slug` = :slug WHERE `id` = :id";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':name' => $input->getName(),
                ':slug' => $input->getSlug(),
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