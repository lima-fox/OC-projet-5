<?php
namespace App\Controllers;



use App\User;

class HomeController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

       
    public function apropos()
    {
        $this->tpl->view("about.html.twig");
    }

    public function admin()
    {
        $this->tpl->view("/admin/starter.html.twig");
    }

    public function index()
    {
        $user_id = null;
        $user = null;
        if(isset($_SESSION['user_login']))
        {
            $user_id = $_SESSION['user_login'];
            $user = User::getById($user_id);
        }


        $this->tpl->view("index.html.twig", ['user'=> $user]);
    }

    public function auth()
    {
        $error = null;
        if(isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }

        $this->tpl->view("authentication.html.twig" , ['error'=>$error]);
    }
    
    
    
}

