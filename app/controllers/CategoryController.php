<?php

namespace App\Controllers;

use App\Core\Controller;

use App\Controllers\Services\CategoryServices as CategoryServices;
class CategoryController extends Controller
{   

    /**
     * declare user variables
     * @param string
     * @return Response
     */
    public $response;

     /**
     * declare category variables
     * @param string
     * @return CategoryServices
     */
    protected $_categoryServices;

    public function __construct()
    {
        $this->_categoryServices = new CategoryServices();
    }

    public function index()
    {   
        $data = $this->_categoryServices->index();
        return $data;
    }

    public function createCategory()
    {
        $data = $this->_categoryServices->createCategory();
        return $data;
    }

    public function getCategory($id)
    {
        $data = $this->_categoryServices->getCategory($id);
        return $data;
    }

    public function updateCategory($id)
    {
        $data = $this->_categoryServices->updateCategory($id);
        return $data;
    }

    public function deleteCategory($id)
    {
        $data = $this->_categoryServices->deleteCategory($id);
        return $data;
    }
}
