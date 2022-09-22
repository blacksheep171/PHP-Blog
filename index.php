<?php
session_start();
require_once "./app/core/App.php";
require_once "./app/core/Controller.php";
require_once "./app/core/Database.php";
$config = require_once "./config/config.php";

App::setConfig($config);
// print_r($_REQUEST);
// echo "<pre>";
// print_r (App::getConfig());
$myApp = new App(); 
$myApp->run();
?>