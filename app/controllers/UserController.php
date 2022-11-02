<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Controllers\Services\UserServices as UserServices;

class UserController extends Controller
{      

    /**
     * declare user variables
     * @param string
     * @return UserService
     */
    protected $_userService;

    public function __construct()
    {   
       $this->_userService = new UserServices();
    }

    public function index()
    {
        $data = $this->_userService->index();
        return $data;
    }

    public function login()
    {
        $data = $this->_userService->login();
        return $data;
    }

    public function createUser()
    {
        $data = $this->_userService->createUser();
        return $data;
    }

    public function getUser($id)
    {
        $data = $this->_userService->getUser($id);
        return $data;
    }

    public function updateUser($id)
    {
        $data = $this->_userService->updateUser($id);
        return $data;
    }

    public function deleteUser($id)
    {
        $data = $this->_userService->deleteUser($id);
        return $data;
    }

    public function changeUserPassword($id)
    {   
        $data = $this->_userService->changeUserPassword($id);
        return $data;
    }

    public function upload()
    {
        $data = $this->_userService->upload();
        return $data;
    }
}
