<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category as Category;
use App\Helpers\Log as Log;
use App\Http\Response as Response;
use App\Models\Repository\CategoryRepository as CategoryRepository;

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
     * @return CategoryRepository
     */
    protected $category;

    public function __construct()
    {   
        $this->response = new Response();
        $this->category = new CategoryRepository();
    }

    public function index()
    {   
        $data = $this->category->index();

        if (!empty($data)) {
            $category = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        }

        return $this->response->responses($category);
    }

    public function createCategory()
    {
        $input = new Category();

        if (isset($_POST['name']) && $_POST['slug']) {
            $input->setName(htmlentities($_POST['name']));
            $input->setSlug(htmlentities($_POST['slug']));

            $data = $this->category->create($input);

            if (!empty($data)) {
                $category = $this->response->sendWithCode(true, 201,'created successfully.', $data);
            }
        } else {
            $category = $this->response->sendWithCode(false, 500,'created failed.', null);
        }

        return $this->response->responses($category);
    }

    public function getCategory($id)
    {
        $data = $this->category->get($id);

          if (!empty($data)) {
            $category = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        }

        return $this->response->responses($category);
    }

    public function updateCategory($id)
    {
        $input = new Category();
        $oldData = $this->category->get($id);

        if (empty($oldData)) {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $input->setName(htmlentities($_POST['name']));
            $input->setSlug(htmlentities($_POST['slug']));
            $input->setId(htmlentities($id));
            $data = $this->category->update($input);
            if ($data) {
                $category = $this->response->sendWithCode(true, 200,'updated successfully.', $data);
            } else {
                $category = $this->response->sendWithCode(true, 200,'updated failed.', $oldData);
            }
        }

        return $this->response->responses($category);
    }

    public function deleteCategory($id)
    {
        
        $oldData = $this->category->get($id);

        if (empty($oldData)) {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->category->delete($id);
            
            $category = $this->response->sendWithCode(true, 200,'delete successfully.', null);
        }

        return $this->response->responses($category);
    }
}
