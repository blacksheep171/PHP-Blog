<?php

// namespace app\core;

class Router {

    private static $routers = [];

    function __construct(){

    }

    public static function getPathInfo($path){
        $path_elements = explode("/", $path);
        $tempPI = "";
        if (isset($path_elements[2])){
            for ($i = 2 ;$i < count($path_elements); $i++ )
                $tempPI .= "/".$path_elements[$i];
        }
        return $tempPI;
    }

    private function getRequestURL() {
        $path_info = $this->getPathInfo($_SERVER['REQUEST_URI']);
        return isset($path_info) ? $path_info : '/';
        // $basePath = \App::getConfig()['basePath'];
        // $url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        // return explode("/",filter_var(trim($url,"/")) );

        // $url = str_replace($this->basePath, '', $url);
        // $url === "" || empty($url) ? "/" : $url;
        // return $url;
    }
    
    private function getRequestMethod() {
        $method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        return $method;
    }

    private static function addRouter($method,$url, $action) {
        self::$routers[] = [$method,$url,$action];
    }
    public static function get($url,$action) {
        self::addRouter('GET',$url, $action);
    }
    public static function post($url,$action) {
        self::addRouter('POST',$url, $action);
    }
    public static function put($url,$action) {
        self::addRouter('PUT',$url, $action);
    }
    public static function delete($url,$action) {
        self::addRouter('DELETE',$url, $action);
    }
    public static function any($url,$action) {
        self::addRouter('GET|POST|PUT|DELETE',$url, $action);
    }

    public function map() {

        $checkRoute = false;
        $params 	= [];

        $requestURL = $this->getRequestURL();
        $requestMethod = $this->getRequestMethod();
        $routers = self::$routers;
        foreach($routers as $route) {
            list($method, $url, $action) = $route;
            if(strpos($method, $requestMethod) === FALSE) {
                continue;
            }
            if ($url === "*") {
                $checkRoute = true;
            } elseif (strpos($url, "{") === FALSE) {
                if(strcmp(strtolower($url),strtolower($requestURL)) === 0) {
                    $checkRoute = true; 
                } else {
                continue;
                }
            } elseif (strpos($url, "}") === FALSE) {
                continue;
            } else {
                $routeParams = explode("/", $url);
                $requestParams = explode("/", $requestURL);
                
                if( count($routeParams) !== count($requestParams) ) {
                    continue;
                }

                foreach($routeParams as $key => $value) {
                    if( preg_match('/^{\w+}$/',$value)) {
                        $params[] = $requestParams[$key];
                    }
                }
                $checkRoute = true;
            }
            
            if( $checkRoute === true ) {
                if(is_callable($action)){
                    call_user_func_array($action, $params);
                } 
                elseif(is_string($action)){
                    $this->compieRoute($action, $params);
                }
                return;
            } else {
                continue;
            }
            
        }
        return;
    }

    private function compieRoute($action, $params){

        if(count(explode('@',$action)) !== 2){
            die("router error");
        }
        $className = explode('@', $action)[0];
        $methodName = explode('@', $action)[1];
        
        $classNameSpace = 'app\\controllers\\'.$className;
        if(class_exists($classNameSpace)) {
            $object = new $classNameSpace;
            if(method_exists($classNameSpace, $methodName)){
                call_user_func_array([$object, $methodName], $params);
            } else {
                die('Method "'.$methodName.'" not found');
            }
        } else {
            die('Class "'.$className.'" not found');
        }
    }
    function run() {
        $this->map();
    }
    
}