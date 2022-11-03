<?php 
namespace App\Controllers\Services;

use App\Models\Category as Category;
use App\Helpers\Log as Log;
use App\Http\Request as Request;
use App\Http\Response as Response;
use App\Models\Repository\CategoryRepository as CategoryRepository;

class CategoryServices {

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
     * declare category variables
     * @param string
     * @return CategoryRepository
     */
    protected $_categoryRepository;

    public function __construct()
    {   
        $this->request = new Request();
        $this->response = new Response();
        $this->_categoryRepository = new CategoryRepository();
    }

    public function index()
    {   
        $data = $this->_categoryRepository->index();

        if (!empty($data)) {
            $category = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $category = $this->response->sendWithCode(false, 400,'no result found', null);
        }

        return $this->response->responses($category);
    }

    public function createCategory()
    {
        $input = new Category();

        if (isset($_POST['name']) && $_POST['slug']) {
            $input->setName($this->request->post('name'));
            $input->setSlug($this->request->post('slug'));

            $data = $this->_categoryRepository->create($input);

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
        $data = $this->_categoryRepository->get($id);

          if (!empty($data)) {
            $category = $this->response->sendWithCode(true, 200,'success', $data);
            
        } else {
            $category = $this->response->sendWithCode(false, 400,'no result found', null);
        }

        return $this->response->responses($category);
    }

    public function updateCategory($id)
    {
        $input = new Category();
        $oldData = $this->_categoryRepository->get($id);

        if (empty($oldData)) {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $input->setName($this->request->post('name'));
            $input->setSlug($this->request->post('slug'));
            $input->setId($id);
            $data = $this->_categoryRepository->update($input);
            if ($data) {
                $category = $this->response->sendWithCode(true, 200,'updated successfully.', $data);
            } else {
                $category = $this->response->sendWithCode(false, 500,'updated failed.', $oldData);
            }
        }

        return $this->response->responses($category);
    }

    public function deleteCategory($id)
    {
        
        $oldData = $this->_categoryRepository->get($id);

        if (empty($oldData)) {
            $category = $this->response->sendWithCode(false, 404,'not found', null);
        } else {
            $this->_categoryRepository->delete($id);
            
            $category = $this->response->sendWithCode(true, 200,'delete successfully.', null);
        }

        return $this->response->responses($category);
    }
}