<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment as Comment;

class CommentController extends Controller{
   
    function __construct()
    {
        header('Content-type: application/json');
    }
    public function index(){

        $post = new Comment;
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
                [   "success" => false,
                    "message" => "not found",
                    "code" => 200,
                    "data" => null
            ]);
        }
    }

    public function createComment(){

        $comments = new Comment;

        if(isset($_POST['comment']) && isset($_POST['reply']) && isset($_POST['user_id']) && isset($_POST['post_id'])){
            $comment = $_POST['comment'];
            $reply = $_POST['reply'];
            $user_id = $_POST['user_id'];
            $post_id = $_POST['post_id'];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $data = $comments->create($comment, $reply, $user_id ,$post_id, $created_at, $updated_at);

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
                    "message" => "comment could not be created.",
                    "code" => 500,
                    "data" => null
            ]);
        }
    }

    public function getComment($id) {

        $comment = new Comment;
        $data = $comment->get($id);
        
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
    
    public function updateComment($id) {

        $comments = new Comment;
        $old_data = $comments->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $comment = $_POST['comment'];
            $reply = $_POST['reply'];
            $user_id = $_POST['user_id'];
            $post_id = $_POST['post_id'];
            $updated_at = date('Y-m-d H:i:s');

            $data = $comments->update($id, $comment, $reply, $user_id, $post_id, $updated_at);

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
                        "message" => "Comment can not updated.",
                        "code" => 500,
                        "data" => null
                ]);
            }
        }
    }

    public function deleteComment($id){

        $post = new Comment;
        $old_data = $post->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $post->delete($id);
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]);
        }
    }
}
