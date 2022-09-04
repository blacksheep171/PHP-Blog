<?php 

namespace app\controllers;

use app\core\Controller;

class UserController extends Controller
{

    function __construct(){
        header('Content-type: application/json');
    }

    function handlePage($page){
        echo $page;
    }

    public function index(){
        // code here
        
        $users = $this->model("UsersModel");
        $data = $users->index();
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
    public function create(){
        $users = $this->model("UsersModel");

        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $gender = $_POST['gender'];
        $avatar = $_POST['avatar'];
        $created_at = date('Y-m-d H:i:s');
        $updated_at = date('Y-m-d H:i:s');

        $data = $users->create($fullname, $email,$password,$gender, $avatar, $created_at, $updated_at);

        if($data){
            http_response_code(201);
            echo json_encode(
                [   "success" => true,
                    "message" => "Created successfully.",
                    "code" => 201,
                    "data" => $data
            ]);
        } else{
            http_response_code(500);
            return json_encode(
                [   "success" => false,
                    "message" => "Users could not be created.",
                    "code" => 500,
                    "data" => $data
            ]);
        }
    }

    public function updates($id){
        // if(isset($_POST['id']) && isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['gender']) && isset($_POST['avatar']) && isset($_POST['updated_at'])){
        $users = $this->model("UsersModel");
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $gender = $_POST['gender'];
        $avatar = $_POST['avatar'];
        $updated_at = date('Y-m-d H:i:s');

        $data = $users->update($id,$fullname, $email,$password,$gender, $avatar, $updated_at);
    if($data){
        http_response_code(200);
        echo json_encode(
            [   "success" => true,
                "message" => "updated successfully.",
                "code" => 200,
                "data" => $data
        ]);
    // }
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

    public function getUser($id){
        // code here        
        $users = $this->model("UsersModel");
        $data = $users->getUser($id);
        
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

    public function delete($id){
        // code here        
        $users = $this->model("UsersModel");
        $users->delete($id);
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]);
    }
}