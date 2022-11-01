<?php

namespace App\Controllers;

use App\Helpers\Log as Log;
use App\Http\Response as Response;
use App\Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {

    }
    public function index()
    {
        return $this->view('Home/homepage');
    }
}
