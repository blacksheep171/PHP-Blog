<?php
session_start();
// require_once "./app/Connection.php";
require_once "./app/core/App.php";
require_once "./app/core/Controller.php";
require_once "./app/core/Database.php";
$config = require_once "./config/config.php";

App::setConfig($config);
// echo "<pre>";
// print_r (App::getConfig());
$myApp = new App(); 
$myApp->run();
?>