<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\Services\CommentServices as CommentServices;

class CommentController extends Controller
{   
    /**
     * declare comment variables
     * @param string
     * @return CommentServices
     */
    protected $_commentServices;

    public function __construct()
    {   
        $this->_commentServices = new CommentServices();
    }

    public function index()
    {
       $data = $this->_commentServices->index();
       return $data;
    }

    public function createComment()
    {
        $data = $this->_commentServices->createComment();
        return $data;
    }

    public function getComment($id)
    {
        $data = $this->_commentServices->getComment($id);
        return $data;
    }

    public function updateComment($id)
    {
        $data = $this->_commentServices->updateComment($id);
        return $data;
    }

    public function deleteComment($id)
    {
        $data = $this->_commentServices->deleteComment($id);
        return $data;
    }
}
