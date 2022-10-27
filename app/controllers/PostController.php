<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post as Post;
use App\Models\Repository\PostRepository as PostRepository;
class PostController extends Controller
{
     /**
     * declare post variables
     * @param string
     * @return PostRepository
     */
    protected $post;

    public function __construct()
    {   
        $this->post = new PostRepository();
        header('Content-type: application/json');
    }

    public function index()
    {
        $data = $this->post->index();

        if (!empty($data)) {
            http_response_code(200);
            echo json_encode(
                [   "success" => true,
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
                    "code" => 200,
                    "data" => null
            ]
            );
        }
    }

    public function createPost()
    {
        $input = new Post();

        if (isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['summary']) && isset($_POST['content']) && isset($_POST['user_id']) && isset($_POST['user_id'])) {
            $input->setTitle(htmlentities($_POST['title']));
            $input->setSlug(htmlentities($_POST['slug']));
            $input->setSummary(htmlentities($_POST['summary']));
            $input->setContent(htmlentities($_POST['content']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));

            $data = $this->post->create($input);

            if ($data) {
                http_response_code(201);
                echo json_encode(
                    [   "success" => true,
                        "message" => "Created successfully.",
                        "code" => 201,
                        "data" => $data
                ]
                );
            }
        } else {
            http_response_code(500);
            return json_encode(
                [   "success" => false,
                    "message" => "post could not be created.",
                    "code" => 500,
                    "data" => null
            ]
            );
        }
    }

    public function getPost($id)
    {
        $data = $this->post->get($id);

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

    public function updatePost($id)
    {
        $input = new Post();
        $oldData = $this->post->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
            [   
                "success" => false,
                "message" => "not found",
                "code" => 404,
                "data" => null
            ]);
        } else {
            $input->setTitle(htmlentities($_POST['title']));
            $input->setSlug(htmlentities($_POST['slug']));
            $input->setSummary(htmlentities($_POST['summary']));
            $input->setContent(htmlentities($_POST['content']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->post->update($input);
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
                        "message" => "updated failed.",
                        "code" => 500,
                        "data" => null
                ]
                );
            }
        }
    }

    public function deletePost($id)
    {
        $oldData = $this->post->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]
            );
        } else {
            $this->post->delete($id);
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
