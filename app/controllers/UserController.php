<?php 

namespace App\Controllers;

use App;
use App\Core\Controller;
use App\Models\User as User;
use App\Models\Gallery as Gallery;

class UserController extends Controller
{

    function __construct(){
        header('Content-type: application/json');
    }

    function handlePage($page){
        echo $page;
    }

    public function index(){
        
        $users = new User;
        $data = $users->index();
    
        if(!empty($data)){
            http_response_code(200);
            header('Content-type: application/json');
            echo json_encode(
                [
                    "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]);
        } else {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        }

    }
   
    public function createUser(){

        $users =  new User;
        
        $fullname = $_POST['full_name'];
        $email = htmlentities($_POST['email']);
        $password = htmlentities(password_hash(($_POST['password']), PASSWORD_DEFAULT));
        $gender = htmlentities($_POST['gender']);
        $avatar = htmlentities($_POST['avatar']);
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

    public function getUser($id) {

        $users =  new User;
        $data = $users->get($id);
        
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

    public function updateUser($id){

        $users =  new User;
        $old_data = $users->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $fullname = $_POST['full_name'];
            $email = $_POST['email'];
            $gender = $_POST['gender'];
            $avatar = $_POST['avatar'];
            $updated_at = date('Y-m-d H:i:s');

            $data = $users->update($id, $fullname, $email, $gender, $avatar, $updated_at);

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
    }

    public function deleteUser($id){

        $users =  new User;
        $old_data = $users->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
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

    public function changeUserPassword($id){

        $users =  new User;
        $password = isset($_POST['password']) ? password_hash(($_POST['password']), PASSWORD_DEFAULT) : null;
        $old_data = $users->find($id);
        
        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $data = $users->changePassword($id,$password);
            if($data){
                http_response_code(200);
                echo json_encode(
                    [   "success" => true,
                        "message" => "password changed successfully.",
                        "code" => 200,
                        "data" => $data
                ]);
            } else{
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "password can not changed.",
                        "code" => 500,
                        "data" => null
                ]);
            }
        }
    }


    public function upload() {
        $image = new Gallery;
        $targetDir = 'public/uploads';
        $targetFile = $targetDir.basename($_FILES["fileToUpload"]["name"]);
        // declare
        $fileName = $_FILES['fileToUpload']['name'];
        $filePath = $_FILES['fileToUpload']['tmp_name'];
        $fileSize = $_FILES['fileToUpload']['size'];
        $error = [];    
        $imageUrl = App::getConfig()['basePath'].$targetFile;
        if(empty($fileName)){
             $error[] = 'please select an images';
        } else {
            $fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION));
            //extension
            $extension = ['jpg', 'png', 'gif', 'jpeg','gif'];

            if(in_array($fileExt, $extension)) {
                if(!file_exists($targetDir.$fileName)){
                    if($fileSize < 5000000) {
                        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile);
                    } else {
                        $error[] = 'Sorry your file is too large';
                    }
                } else {
                    $error[] = 'Sorry, file already exists check upload folder';
                }
            } else {
                $error[] = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed';
            }
        }
        
        if(empty($error)) {
            $image->upload($fileName,$imageUrl);
            $data = [
                'name' => $fileName,
                'path' => $imageUrl
            ];
             http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => 'success',
                    "code" => 200,
                    "data" => $data
            ]);
        } else {
             http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => $error[0],
                    "code" => 404,
                    "data" => null
            ]);
        }
    }
}