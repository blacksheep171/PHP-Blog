<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller{
   
    function __construct()
    {
        // echo "home page";
    }
    function index(){
        echo "welcome to home page";
    }

    function get_page($list,$page){
        echo "welcome".$list."number: ".$page;
    }

}