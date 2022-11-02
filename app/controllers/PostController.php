<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\Services\PostServices as PostServices;

class PostController extends Controller
{   
     /**
     * declare post variables
     * @param string
     * @return PostServices
     */
    protected $_postServices;

    public function __construct()
    {   
        $this->_postServices = new PostServices();
    }

    public function index()
    {
        $data = $this->_postServices->index();
        return $data;
    }

    public function createPost()
    {
        $data = $this->_postServices->createPost();
        return $data;
    }

    public function getPost($id)
    {
        $data = $this->_postServices->getPost($id);
        return $data;
    }

    public function updatePost($id)
    {
        $data = $this->_postServices->updatePost($id);
        return $data;
    }

    public function deletePost($id)
    {
        $data = $this->_postServices->deletePost($id);
        return $data;
    }
}
