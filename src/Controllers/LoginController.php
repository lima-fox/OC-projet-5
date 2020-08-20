<?php
namespace App\Controllers;
use App\User;

class LoginController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function connect()
    {

        $user = User::verify($_POST['login'], $_POST['pass']);

        if($user != null)
        {
            $_SESSION['user_login'] = $user->getId();
            header('Location: /');
        }
        else
        {
            $_SESSION['error'] = "Identifiant ou mot de passe incorrects";
            header('Location: /seconnecter');
        }

    }



    
}