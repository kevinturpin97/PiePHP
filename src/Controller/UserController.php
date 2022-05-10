<?php

namespace Controller;

use Core\Controller;

class UserController extends \Core\Controller
{
    public function __construct()
    {
        autoload("src/Model/UserModel");
    }

    public function addAction()
    {
        if (!isset($_SESSION['user']))
            $this->render('register');
        else
            header("Location: /app/index");
    }

    public function logAction()
    {
        if (!isset($_SESSION['user']))
            $this->render('login');
        else
            header("Location: /app/index");
    }

    public function registerAction()
    {
        if ((isset($_POST["email"]) && isset($_POST["password"])) && !isset($_SESSION['user'])) {
            try {
                $params = new Controller();
                $params = $params->request->getQueryParams();
                $user = new \Model\UserModel($params);
                if (!$user->id) {
                    $user->save();
                    self::$_render = "Votre compte a été crée." . PHP_EOL;
                }
            } catch (\Throwable $th) {
                echo "Une erreur est survenue lors de l'inscription, veuillez réessayer.";
            }
        }
    }

    public function loginAction()
    {
        if ((isset($_POST["email"]) && isset($_POST["password"])) && !isset($_SESSION['user'])) {
            try {
                $params = new Controller;
                $params = $params->request->getQueryParams();
                $user = new \Model\UserModel($params);
                if ($user->login()) {
                    echo "Vous êtes connecté !";
                } else {
                    echo "Adresse mail et/ou mot de passe incorrect.";
                }
            } catch (\Throwable $th) {
                echo "Une erreur est survenue lors de la connexion, veuillez réessayer.";
                echo $th;
            }
        }
    }

    public function logoutAction()
    {
        session_destroy();
        echo "Vous êtes deconnecté." . PHP_EOL;
    }

    public function showAction(int $id=null)
    {
        echo "ID de l'utilisateur a afficher: " . $id . PHP_EOL;
    }

    public function ArticleAction()
    {
        require_once ('src/Model/ArticleModel.php');
        $article = new \Model\ArticleModel(3);
     var_dump($article::$info);
    }
}
