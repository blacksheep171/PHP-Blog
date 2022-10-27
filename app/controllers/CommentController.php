<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Comment as Comment;
use App\Models\Repository\CommentRepository as CommentRepository;

class CommentController extends Controller
{   
    /**
     * declare comment variables
     * @param string
     * @return CommentRepository
     */
    protected $comment;

    public function __construct()
    {   
        $this->comment = new CommentRepository();
        header('Content-type: application/json');
    }

    public function index()
    {
        $data = $this->comment->index();

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

    public function createComment()
    {
        $input = new Comment();

        if (isset($_POST['comment']) && isset($_POST['reply']) && isset($_POST['user_id']) && isset($_POST['post_id'])) {
            $input->setComment(htmlentities($_POST['comment']));
            $input->setReply(htmlentities($_POST['reply']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setPostId(htmlentities($_POST['post_id']));
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));

            $data = $this->comment->create($input);

            if ($data) {
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

    public function getComment($id)
    {
        $data = $this->comment->get($id);

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

    public function updateComment($id)
    {
        $input = new Comment();
        $oldData = $this->comment->get($id);

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
            $input->setComment(htmlentities($_POST['comment']));
            $input->setReply(htmlentities($_POST['reply']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setPostId(htmlentities($_POST['post_id']));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->comment->update($input);

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

    public function deleteComment($id)
    {
        $oldData = $this->comment->get($id);

        if (empty($oldData)) {
            http_response_code(404);
            echo json_encode(
                [   "success" => false,
                    "message" => "not found",
                    "code" => 404,
                    "data" => null
            ]);
        } else {
            $this->comment->delete($id);
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
