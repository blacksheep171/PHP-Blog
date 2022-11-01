<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Post as Post;
use App\Helpers\Log as Log;
use App\Http\Response as Response;
use App\Models\Repository\PostRepository as PostRepository;
class PostController extends Controller
{   
     /**
     * declare user variables
     * @param string
     * @return Response
     */
    public $response;

     /**
     * declare post variables
     * @param string
     * @return PostRepository
     */
    protected $post;

    public function __construct()
    {   
        $this->response = new Response();
        $this->post = new PostRepository();
    }

    public function index()
    {
        $data = $this->post->index();

        if (!empty($data)) {
            $post = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $post = $this->response->sendWithCode(false, 404,'not found', $data);
        }

        return $this->response->responses($post);
    }

    public function createPost()
    {
        $input = new Post();

        $input->setTitle(htmlentities($_POST['title']));
        $input->setSlug(htmlentities($_POST['slug']));
        $input->setSummary(htmlentities($_POST['summary']));
        $input->setContent(htmlentities($_POST['content']));
        $input->setUserId(htmlentities($_POST['user_id']));
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->post->create($input);

        if ($data) {  
            $post = $this->response->sendWithCode(true, 201,'created successfully.', $data);
        } else {
            $post = $this->response->sendWithCode(false, 404,'created failed', null);
        }

        return $this->response->responses($post);
    }

    public function getPost($id)
    {
        $data = $this->post->get($id);

        if (!empty($data)) {
            $post = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $post = $this->response->sendWithCode(false, 404,'not found', null);
        }

        return $this->response->responses($post);
    }

    public function updatePost($id)
    {
        $input = new Post();
        $oldData = $this->post->get($id);

        if (empty($oldData)) {
            $post = $this->response->sendWithCode(false, 404,'not found', null);
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
                $post = $this->response->sendWithCode(true, 200,'updated successfully.', $data);
            } else {
                $post = $this->response->sendWithCode(true, 500,'updated failed.', $oldData);
            }
        }

        return $this->response->responses($post);
    }

    public function deletePost($id)
    {
        $oldData = $this->post->get($id);
        
        if (empty($oldData)) {
            $post = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->post->delete($id);
            $post = $this->response->sendWithCode(true, 200,'delete successfully.',null);
        }
        
        return $this->response->responses($post);
    }
}
