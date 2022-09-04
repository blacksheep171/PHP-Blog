<?php

require_once (dirname(__FILE__).'/Autoload.php');

// use app\core\Router;

class App {

    private $router;
    
    public static $config;

    function __construct()
    {   
        new Autoload(self::$config['rootDir']);
        $this->router = new Router;

    }

    public static function setConfig($config) {
        self::$config = $config;
    }
    public static function getConfig(){
        return self::$config;
    }

    public function run(){
        $this->router->run();
    }
  
}