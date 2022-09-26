<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller{
   
    function __construct()
    {
        // echo "home page";
    }
    function index(){
        echo "welcome to home page";
    }

}