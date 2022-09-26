<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category as Category;
class CategoryController extends Controller{
   
    function __construct()
    {
        header('Content-type: application/json');
    }

    public function index(){ 

        $category = new Category;
        $data = $category->index();

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
                    "code" => 404,
                    "data" => null
            ]);
        }
    }

    public function createCategory(){

        $post = new Category;

        if(isset($_POST['name']) && $_POST['slug']){
            $name = $_POST['name'];
            $slug = $_POST['slug'];

            $data = $post->create($name, $slug);

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
                    "message" => "category could not be created.",
                    "code" => 500,
                    "data" => null
            ]);
        }
    }

    public function getCategory($id){     

        $category = new Category;
        $data = $category->get($id);
        
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

    public function updateCategory($id){

        $category = new Category;
        $old_data = $category->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $data = $category->update($id, $name, $slug);
            if($data) {
                http_response_code(200);
                echo json_encode(
                    [   "success" => true,
                        "message" => "updated successfully.",
                        "code" => 200,
                        "data" => $data
                ]);
            } else {
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "Category can not updated.",
                        "code" => 500,
                        "data" => null
                ]);
            }
        }
    }

    public function deleteCategory($id){

        $category = new Category;
        $old_data = $category->find($id);

        if(empty($old_data)){
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $category->delete($id);
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
