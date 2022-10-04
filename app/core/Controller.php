<?php 
namespace App\Core;

require_once "./vendor/autoload.php";

class Controller {

    public function view($view, $data=[]){
            require_once "./App/Views/".$view.".php";
    }
    
}
