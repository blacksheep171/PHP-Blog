<?php 
namespace App\Controllers\Services;

use App\Models\Comment as Comment;
use App\Helpers\Log as Log;
use App\Http\Request as Request;
use App\Http\Response as Response;
use App\Models\Repository\CommentRepository as CommentRepository;

class CommentServices {
    /**
     * declare request variables
     * @param string
     * @return Request
     */
    public $Request;

      /**
     * declare user variables
     * @param string
     * @return Response
     */
    public $response;

     /**
     * declare comment variables
     * @param string
     * @return CommentRepository
     */
    protected $_commentRepository;

    public function __construct()
    {   
        $this->request = new Request();
        $this->response = new Response();
        $this->_commentRepository = new CommentRepository();
    }

    public function index()
    {
        $data = $this->_commentRepository->index();

        if (!empty($data)) {
            $comment = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $comment = $this->response->sendWithCode(false, 400,'no result found', $data);
        }

        return $this->response->responses($comment);
    }

    public function createComment()
    {
        $input = new Comment();

        if (isset($_POST['comment']) && isset($_POST['reply']) && isset($_POST['user_id']) && isset($_POST['post_id'])) {
            // need validate user
            $input->setComment(htmlentities($_POST['comment']));
            $input->setReply(htmlentities($_POST['reply']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setPostId(htmlentities($_POST['post_id']));
            $input->setCreatedAt(date('Y-m-d H:i:s'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));

            $data = $this->_commentRepository->create($input);

            if ($data) {
                $comment = $this->response->sendWithCode(true, 201,'created successfully.', $data);
            }
        } else {
            $comment = $this->response->sendWithCode(false, 500,'created failed.', null);
        }

        return $this->response->responses($comment);
    }

    public function getComment($id)
    {
        $data = $this->_commentRepository->get($id);

        if (empty($data)) {
            $comment = $this->response->sendWithCode(false, 400,'no result found', null);
        } else {
            $comment = $this->response->sendWithCode(true, 200,'success', $data);
        }

        return $this->response->responses($comment);
    }

    public function updateComment($id)
    {
        $input = new Comment();
        $oldData = $this->_commentRepository->get($id);

        if (empty($oldData)) {
            $comment = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $input->setComment(htmlentities($_POST['comment']));
            $input->setReply(htmlentities($_POST['reply']));
            $input->setUserId(htmlentities($_POST['user_id']));
            $input->setPostId(htmlentities($_POST['post_id']));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->_commentRepository->update($input);

            if ($data) {
                $comment = $this->response->sendWithCode(true, 200,'updated successfully.', $data);
            } else {
                $comment = $this->response->sendWithCode(false, 500,'updated failed.', $oldData);
            }
        }

        return $this->response->responses($comment);

    }

    public function deleteComment($id)
    {
        $oldData = $this->_commentRepository->get($id);

        if (empty($oldData)) {
            $comment = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->_commentRepository->delete($id);
            $comment = $this->response->sendWithCode(true, 200,'success', null);
        }

        return $this->response->responses($comment);
    }
}