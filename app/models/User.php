<?php
namespace App\Models;

class User {

    protected $table = "users";

    public $id;
    public $fullName;
    public $email;
    public $password;
    public $gender;
    public $avatar;
    public $createdAt;
    public $updatedAt;  

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setFullName($fullName){
        $this->fullName = $fullName;
    }

    public function getFullName(){
        return $this->fullName;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setGender($gender){
        $this->gender = $gender;
    }

    public function getGender(){
        return $this->gender;
    }

    public function setAvatar($avatar){
        $this->avatar = $avatar;
    }

    public function getAvatar(){
        return $this->avatar;
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
?>
