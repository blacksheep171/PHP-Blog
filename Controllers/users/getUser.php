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
    $items->id = isset($_GET['id']) ? $_GET['id'] : die();

    $items->getUser();
    if($items->fullname != null){
        // create array
        $data = array(
            "id" =>  $items->id,
            "fullname" => $items->fullname,
            "email" => $items->email,
            "gender" => $items->gender,
            "avatar" => $items->avatar,
            "created_at" => $items->created_at,
            "updated_at" => $items->updated_at
        );
                http_response_code(200);
                echo json_encode(
                    [   "success" => true,
                        "message" => "success",
                        "code" => 200,
                        "data" => $data
                ],200);
            }
    else {
        http_response_code(404);
        echo json_encode(
            [   "success" => false,
                "message" => "not found",
                "code" => 404,
                "data" => null
        ],404);
    }
?>