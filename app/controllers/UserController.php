<?php 

namespace app\controllers;

use core\Controller;

class UserController extends Controller
{

    function __construct(){
        header('Content-type: application/json');
    }

    function handlePage($page){
        echo $page;
    }

    public function get_all(){
        // code here
        
        $users = $this->model("UsersModel");
        $data = $users->getUsers();
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
   
}