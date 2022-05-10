<?php
namespace Core;

class Controller
{

    protected $request;
    static protected $_render;

    public function __construct() {
        $this->request = new Request($_POST, $_GET);
    }

    protected function render($view, $scope = [])
    {
        extract($scope);
        $f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', substr(str_replace('Controller', '', basename(get_class($this))), 1), $view]) . ".php";
        if (file_exists($f)) {
            ob_start();
            include ($f);
            $view = ob_get_clean();
            ob_start();
            include (implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', 'View', 'index']) . ".php");
            self::$_render = ob_get_clean();

            $test = "{{\$view}}";
            $test = preg_replace("/({{)/", "<?=", $test);
            $test = preg_replace("/(}})/", "?>", $test);
           
            echo $view;
            print($tt);
        }
    }
    public function __destruct()
    {
        echo self::$_render;
    }
}