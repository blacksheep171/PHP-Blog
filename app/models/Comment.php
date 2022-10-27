<?php 
namespace App\Models;

class Comment {

    protected $table = "comments";

    public $id;
    public $comment;
    public $reply;
    public $userId;
    public $postId;
    public $createdAt;
    public $updatedAt;

    public function __construct(){

    }
    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setComment($comment){
        $this->comment = $comment;
    }

    public function getComment(){
        return $this->comment;
    }

    public function setReply($reply){
        $this->reply = $reply;
    }

    public function getReply(){
        return $this->reply;
    }

    public function setUserId($userId){
        $this->userId = $userId;
    }

    public function getUserId(){
        return $this->userId;
    }

    public function setPostId($postId){
        $this->postId = $postId;
    }

    public function getPostId(){
        return $this->postId;
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
