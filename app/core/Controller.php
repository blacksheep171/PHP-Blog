<?php 
namespace App\Core;

require_once "./vendor/autoload.php";

use App\Http\Response;

class Controller {

    /**
     * Response Class.
     * @param string
     * @return Response
     * 
     */
    public $response;

    public function __construct(Response $response) {
        $this->response = $response;
    }
    public function view($view, $data=[]){
            require_once "./App/Views/".$view.".php";
    }
    

    	// send response faster
        public function send($status = 200, $msg) {
            $this->response->setHeader(sprintf('HTTP/1.1 ' . $status . ' %s' , $this->response->getStatusCodeText($status)));
            $this->response->setContent($msg);
        }
}
