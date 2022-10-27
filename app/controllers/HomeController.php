<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        // echo "home page";
    }
    public function index()
    {
        return $this->view('Home/homepage');
    }
}
