<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    include_once ("../../Configs/Database.php");
    include_once ("../../Models/Users.php");
    $database = new Database();
    $db = $database->getConnection();
    $items = new Users($db);
    $data = $items->getUsers();
    $itemCount = $data->rowCount();

    if($itemCount > 0){
        
        $userData = array();
        while ($row = $data->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "fullname" => $fullname,
                "email" => $email,
                "avatar" => $avatar,
                "created_at" => $created_at,
                "updated_at" => $updated_at
            );
                array_push($userData, $e);
        }
        http_response_code(200);
        echo json_encode(
            [   "success" => true,
                "message" => "success",
                "code" => 200,
                "data" => $userData
        ]);
    }
    else{
        http_response_code(404);
        echo json_encode(
            [   "success" => false,
                "message" => "not found",
                "code" => 404,
                "data" => $userData
        ]);
    }
?>