<?php
namespace Core;

class Router
{
    private static $routes;

    public function __construct()
    {
        autoload('Controller/UserController');
    }

    public static function connect($url, $route)
    {
        self::$routes[$url] = $route;
        $redefined = [];
        if (self::get($url)) {
            try {
                if ($url === $_SERVER['REQUEST_URI']) {
                    foreach ($route as $key => $value) {
                        $redefined[] = $value;
                        $redefined[] = $key;
                    }
                    $class = ucfirst($redefined[0]) . ucfirst($redefined[1]);
                    $method = $redefined[2] . ucfirst($redefined[3]);
                    $namespace = ucfirst($redefined[1]);
                    
                    if ($namespace === 'Core') {
                        $object = $class;
                        require_once $class . '.php';
                    } else { 
                        $object = '\\'. $namespace . '\\' . $class;
                        require_once 'src/' . $namespace . '/' . $class . '.php';
                    }
 
                    call_user_func(array(new $object, $method));
                    
                    // DEBUG MODE
                    // echo '<pre> [' . $object . ']  </pre>';
                    // echo 'filename: <pre>' . $class . '.php</pre>';
                    // echo 'method: <pre>' . $method . '</pre>';
                    // echo 'namespace: <pre>' . $namespace . '</pre><br />';
                    return True;
                }
            } catch (\Throwable $error) {
                echo $error;
            }
            return False;
        }
    }

    public static function get($url)
    {
        $url = explode(DIRECTORY_SEPARATOR, $url);
        if (preg_match("/%7Bid%7D/", $url[2])) {
            $class = "\Controller\\" . ucfirst($url[1]) . "Controller";
            require_once "src/Controller/" . ucfirst($url[1]) . "Controller.php";
            $user_id = new $class;
            $user_id->showAction($_SESSION['user']['id']);
            return False;
        }
        return True;
    }
}