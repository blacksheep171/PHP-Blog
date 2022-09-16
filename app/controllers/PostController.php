<?php

namespace app\controllers;

use app\core\Controller;

class PostController extends Controller{
   
    function __construct()
    {
        header('Content-type: application/json');
    }

    public function createPost(){
        $post = $this->model("PostsModel");
        if(isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['summary']) && isset($_POST['content']) && isset($_POST['user_id']) && isset($_POST['user_id'])){
            $title = $_POST['title'];
            $slug = $_POST['slug'];
            $summary = $_POST['summary'];
            $content = $_POST['content'];
            $user_id = $_POST['user_id'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $data = $post->createPost($title, $slug, $summary,$content, $user_id, $created_at, $updated_at);

            if($data){
                http_response_code(201);
                echo json_encode(
                    [   "success" => true,
                        "message" => "Created successfully.",
                        "code" => 201,
                        "data" => $data
                ]);
            }
        } else{
            http_response_code(500);
            return json_encode(
                [   "success" => false,
                    "message" => "Users could not be created.",
                    "code" => 500,
                    "data" => null
            ]);
        }
    }

    public function index(){
        
        $post = $this->model("PostsModel");
        $data = $post->index();
        if(count($data) > 0){
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]);
        } else {
            http_response_code(404);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]);
        }
    }

    public function getPost($id){     
        $users = $this->model("PostsModel");
        $data = $users->getPost($id);
        
        if(empty($data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]);
        }
    }
    
    public function update($id){
       
        $users = $this->model("PostsModel");
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $summary = $_POST['summary'];
        $content = $_POST['content'];
        $user_id = $_POST['user_id'];
        $updated_at = date('Y-m-d H:i:s');

        $data = $users->update($id,$title, $slug,$summary,$content, $user_id, $updated_at);
        if($data){
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "updated successfully.",
                    "code" => 200,
                    "data" => $data
            ]);
        } else{
            http_response_code(500);
            echo json_encode(
                [   "success" => false,
                    "message" => "users can not updated.",
                    "code" => 500,
                    "data" => null
            ]);
        }
    }
    public function deletePost($id){
        // code here        
        $users = $this->model("PostsModel");
        $users->deletePost($id);
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]);
    }
}