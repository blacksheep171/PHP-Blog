<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");
    // header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    // header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once ("../../Configs/Database.php");
    include_once ("../../Models/Users.php");
    $database = new Database();
    $db = $database->getConnection();
    $items = new Users($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $items->id = $data->id;
    
    // users values
    $items->fullname = $data->fullname;
    $items->email = $data->email;
    $items->password = md5($data->password);
    $items->gender = $data->gender;
    $items->avatar = $data->avatar;
    $items->updated_at = date('Y-m-d H:i:s');
    // if(isset($_GET['id'])){
        if($items->updateUsers()) {
            echo json_encode(
                [   "success" => true,
                    "message" => "updated successfully.",
                    "code" => 200,
                    "data" => $items
                ]);

            echo "123";
        }
    // }
     else {
        http_response_code(404);
        echo json_encode(
            [   "success" => false,
                "message" => "not found",
                "code" => 404,
                "data" => null
        ]);
    }
?>