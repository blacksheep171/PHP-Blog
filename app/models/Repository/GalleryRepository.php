<?php

namespace App\Models\Repository;

use App\Core\Database;
use App\Models\Gallery as Gallery;
use App\Helpers\Log as Log;
use PDO;
use Exception;

class GalleryRepository extends Gallery {

    public $db;
    
    public function __construct(){
        $this->db = Database::connect();
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

    public function upload($input) {
        try {
            $sql = "INSERT INTO ".$this->table." (`name`, `path`) VALUES (:name,:path)";
            $stmt = $this->db->prepare($sql);
            $data = [
                ':name' => $input->getName(),
                ':path' => $input->getPath()
            ];
            if($stmt->execute($data)){
                $result = $this->get($this->db->lastInsertId());
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