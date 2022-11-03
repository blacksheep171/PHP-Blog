<?php

namespace App\Controllers\Services;


use App;
use App\Models\Post as Post;
use App\Helpers\Log as Log;
use App\Http\Request as Request;
use App\Http\Response as Response;
use App\Models\Repository\PostRepository as PostRepository;

class PostServices {

     /**
     * declare request variables
     * @param string
     * @return Request
     */
    public $Request;

    /**
     * declare responses variables
     * @param string
     * @return Response
     */
    public $response;

     /**
     * declare post variables
     * @param string
     * @return PostRepository
     */
    protected $_postRepository;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
        $this->_postRepository = new PostRepository();
    }

    public function index()
    {
        $data = $this->_postRepository->index();

        if (!empty($data)) {
            $post = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $post = $this->response->sendWithCode(false, 400,'no results found', $data);
        }

        return $this->response->responses($post);
    }


    public function createPost()
    {
        $input = new Post();

        $input->setTitle($this->request->post('title'));
        $input->setSlug($this->request->post('slug'));
        $input->setSummary($this->request->post('summary'));
        $input->setContent($this->request->post('content'));
        $input->setUserId($this->request->post('user_id'));
        $input->setCreatedAt(date('Y-m-d H:i:s'));
        $input->setUpdatedAt(date('Y-m-d H:i:s'));

        $data = $this->_postRepository->create($input);

        if ($data) {  
            $post = $this->response->sendWithCode(true, 201,'created successfully.', $data);
        } else {
            $post = $this->response->sendWithCode(false, 500,'created failed', null);
        }

        return $this->response->responses($post);
    }

    public function getPost($id)
    {
        $data = $this->_postRepository->get($id);

        if (!empty($data)) {
            $post = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $post = $this->response->sendWithCode(false, 400,'no result found', null);
        }

        return $this->response->responses($post);
    }

    public function updatePost($id)
    {
        $input = new Post();
        $oldData = $this->_postRepository->get($id);

        if (empty($oldData)) {
            $post = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $input->setTitle($this->request->post('title'));
            $input->setSlug($this->request->post('slug'));
            $input->setSummary($this->request->post('summary'));
            $input->setContent($this->request->post('content'));
            $input->setUserId($this->request->post('user_id'));
            $input->setUpdatedAt(date('Y-m-d H:i:s'));
            $input->setId($id);

            $data = $this->_postRepository->update($input);
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
        $oldData = $this->_postRepository->get($id);
        
        if (empty($oldData)) {
            $post = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->_postRepository->delete($id);
            $post = $this->response->sendWithCode(true, 200,'delete successfully.',null);
        }
        
        return $this->response->responses($post);
    }
}