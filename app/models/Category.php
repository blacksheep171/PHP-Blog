<?php 
namespace App\Models;

class Category {

    protected $table = "categories";

    public $id;
    public $name;
    public $slug;
    public function __construct(){

    }
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
    public function setSlug($slug){
        $this->slug = $slug;
    }

    public function getSlug(){
        return $this->slug;
    }
    
}
