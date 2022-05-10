<?php
namespace Controller;

use Core\Controller;

class AppController extends \Core\Controller
{
    public function __construct() 
    {
        autoload("src/Model/UserModel");
    }

    public function indexAction()
    {
        if (isset($_SESSION['user'])) {
            $this->render('index');
        } else {
            header("Location: /user/log");
        }
    }
}