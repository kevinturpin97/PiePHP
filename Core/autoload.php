<?php

// spl_autoload_register(function () {
//     require_once "Core.php";
//     require_once "Router.php";
//     require_once "Controller.php";
//     require_once "src/routes.php";
//     require_once "src/Controller/AppController.php";
// });

function autoload($path)
{
    $path = str_replace('\\', '/', $path);
    if (!preg_match("/.php/", $path)) {
        require_once $path . ".php";
    } else {
        require_once $path;
    }
}

spl_autoload_register("autoload");

function loadClass($class) {
    $srcSubFolders = ['Model', 'View', 'Controller'];
    $nameSpace = explode('\\', $class)[0];
    $className = explode('\\', $class)[1];
    if($nameSpace == 'Core'){
        if (file_exists(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), $class . '.php']))) {
            require_once(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), $class . '.php']));
        }
    } elseif(in_array($nameSpace, $srcSubFolders)) {
        if (file_exists(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', $class . '.php']))) {
            require_once(implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'src', $class . '.php']));
        }
    }
}

spl_autoload_register('loadClass');
// A refaire