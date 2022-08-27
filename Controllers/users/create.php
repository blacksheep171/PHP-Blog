<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include_once ("../../Configs/Database.php");
    include_once ("../../Models/Users.php");
    $database = new Database();
    $db = $database->getConnection();
    $items = new Users($db);
    $data = json_decode(file_get_contents("php://input"));
    
    $items->fullname = $data->fullname;
    $items->email = $data->email;
    $items->password =  md5($data->password);
    $items->gender = $data->gender;
    $items->avatar = $data->avatar;
    $items->created_at = date('Y-m-d H:i:s');
    $items->updated_at = date('Y-m-d H:i:s');

    if($items->createUsers()){
        // echo 'Users created successfully.';
        http_response_code(201);
        echo json_encode(
            [   "success" => true,
                "message" => "Created successfully.",
                "code" => 201,
                "data" => $data
        ]);
    } else{
        // echo 'Users could not be created.';
        http_response_code(500);
        return json_encode(
            [   "success" => false,
                "message" => "Users could not be created.",
                "code" => 500,
                "data" => $data
        ]);
    }
?>