<?php 
namespace App\Models;

class Post {

    protected $table = "posts";

    public $id;
    public $title;
    public $slug;
    public $summary;
    public $content;
    public $userId;
    public $createdAt;
    public $updatedAt;

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setTitle($title){
        $this->title = $title;
    }

    public function getTitle(){
        return $this->title;
    }
    public function setSlug($slug){
        $this->slug = $slug;
    }

    public function getSlug(){
        return $this->slug;
    }
    public function setSummary($summary){
        $this->summary = $summary;
    }

    public function getSummary(){
        return $this->summary;
    }

    public function setContent($content){
        $this->content = $content;
    }

    public function getContent(){
        return $this->content;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function setCreatedAt($createdAt){
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt(){
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt){
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt(){
        return $this->updatedAt;
    }
}
