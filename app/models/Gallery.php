<?php

namespace App\Models;

class Gallery {
    protected $table = 'images';

    public $id;
    public $name;
    public $path;

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
    public function setPath($path){
        $this->path = $path;
    }

    public function getPath(){
        return $this->path;
    }
}