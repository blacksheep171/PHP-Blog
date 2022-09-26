<?php
class Autoload {

    private $rootDir;

    function __construct($rootDir) {
        $this->rootDir = $rootDir;
        spl_autoload_register([$this,'autoload']);
        $this->autoLoadFile();
    }

    private function autoload($class){
        $rootPath = App::getConfig()['rootDir'];
        // print_r($rootPath);die();
        // $className = end(explode('\\',$class));
        $tmp = explode('\\', $class);
        $className = end($tmp);
        $pathName = str_replace($className,'',$class);
        // print_r($pathName);die();
        $filePath = $this->rootDir.'\\'.$pathName.$className.'.php';
        // print_r($filePath);die();

        if(file_exists($filePath)){
            require_once $filePath;
        }
    }

    private function autoLoadFile(){
        foreach($this->defaultFileLoad() as $file) {
            require_once ($this->rootDir.'/'.$file);
        }
    }
    
    private function defaultFileLoad(){
        return [
            './Core/Router.php',
            './Routes/api/Routers.php'
        ];
    }
}
