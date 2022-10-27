<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category as Category;
use App\Models\Repository\CategoryRepository as CategoryRepository;

class CategoryController extends Controller
{   
     /**
     * declare category variables
     * @param string
     * @return CategoryRepository
     */
    protected $category;

    public function __construct()
    {   
        $this->category = new CategoryRepository();
        header('Content-type: application/json');
    }

    public function index()
    {   
        $data = $this->category->index();
        if (!empty($data)) {
            http_response_code(200);
            echo json_encode(
                [   
                    "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]
            );
        } else {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        }
    }

    public function createCategory()
    {
        $input = new Category();

        if (isset($_POST['name']) && $_POST['slug']) {
            $input->setName(htmlentities($_POST['name']));
            $input->setSlug(htmlentities($_POST['slug']));

            $data = $this->category->create($input);

            if (!empty($data)) {
                http_response_code(201);
                echo json_encode(
                    [   "success" => true,
                        "message" => "created successfully.",
                        "code" => 201,
                        "data" => $data
                ]
                );
            }
        } else {
            http_response_code(500);
            return json_encode(
                [   "success" => false,
                    "message" => "created failed.",
                    "code" => 500,
                    "data" => null
            ]
            );
        }
    }

    public function getCategory($id)
    {
        $data = $this->category->get($id);

        if (empty($data)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        } else {
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => $data
            ]
            );
        }
    }

    public function updateCategory($id)
    {
        $input = new Category();
        $oldData = $this->category->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $input->setName(htmlentities($_POST['name']));
            $input->setSlug(htmlentities($_POST['slug']));
            $input->setId(htmlentities($id));
            $data = $this->category->update($input);
            if ($data) {
                http_response_code(200);
                echo json_encode(
                    [   "success" => true,
                        "message" => "updated successfully.",
                        "code" => 200,
                        "data" => $data
                ]
                );
            } else {
                http_response_code(500);
                echo json_encode(
                    [   "success" => false,
                        "message" => "Category can not updated.",
                        "code" => 500,
                        "data" => null
                ]
                );
            }
        }
    }

    public function deleteCategory($id)
    {
        
        $oldData = $this->category->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $this->category->delete($id);
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
                    "message" => "success",
                    "code" => 200,
                    "data" => null
            ]
            );
        }
    }
}
