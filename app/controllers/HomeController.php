<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller{
   
    function __construct()
    {
        // echo "home page";
    }
    function index(){
        return $this->view('Home/homepage');
    }

}