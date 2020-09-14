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

    public function index()
    {
        $this->tpl->view("index.html.twig" );
    }

    public function auth()
    {
        $error = null;
        if(isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        $register_sent = 0;
        if(isset($_SESSION['register_sent'])) {
            $register_sent = $_SESSION['register_sent'];
            unset($_SESSION['register_sent']);
        }

        $this->tpl->view("authentication.html.twig" , ['error'=>$error,
                                                                'register_sent' => $register_sent]);
    }
    
    
    
}

