<?php
namespace Core;

class Core 
{
    public function run()
    {        
        $url = explode(DIRECTORY_SEPARATOR, $_SERVER['REQUEST_URI']);
        //$url[1] = "user"
        //$url[2] = "add"
        // user/add
        $key = 'src/Controller/' . ucfirst($url[1]) . 'Controller.php';
        if ($url[1] !== "") {
            if (file_exists($key)) {
                autoload($key);
                $key = '\Controller\\' . basename($key, '.php');
                if (class_exists($key)) {
                    // $obj = new $key;
                    if (@method_exists(new $key, $url[2] . 'Action')) {
                        Router::connect($_SERVER['REQUEST_URI'], ['controller' => $url[1], 'action' => $url[2]]);
                    } else {
                        $default = substr(get_class_methods(new $key)[1], 0, strpos(get_class_methods(new $key)[1], 'Action'));
                        Router::connect($_SERVER['REQUEST_URI'], ['controller' => $url[1], 'action' => $default]);
                    }
                }
            }
        }
    }
}