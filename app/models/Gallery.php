<?php

namespace App\Models;

use App\Core\Model as Model;

class Gallery extends Model {
    private $table = 'images';

    public $id;
    public $name;
    public $path;

    public function get($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE `id` = :id ";
        $this->db->query($sql);
        $this->db->bind(':id',$id);
        $data = $this->db->single();
        return $data;
    }

    public function upload($name,$path) {
        $sql = "INSERT INTO ".$this->table." (name, path) VALUES (:name,:path)";

        $this->db->query($sql);
        $this->db->bind(':name', $name);
        $this->db->bind(':path',$path);
      
        if($this->db->execute()){
            $insert_id = $this->db->lastInsertId();
            $data = $this->get($insert_id);
            return $data;
        } else {
            return null;
        }
    }
}