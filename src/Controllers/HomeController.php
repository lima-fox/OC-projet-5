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
        $error_hash_pass = null;
        if(isset($_SESSION['error_hash_pass'])) {
            $error_hash_pass = $_SESSION['error_hash_pass'];
            unset($_SESSION['error_hash_pass']);
        }
        $mail_reset = null;
        if(isset($_SESSION['mail_reset'])) {
            $mail_reset = $_SESSION['mail_reset'];
            unset($_SESSION['mail_reset']);
        }
        $password_modify = null;
        if(isset($_SESSION['password_modify'])) {
            $password_modify = $_SESSION['password_modify'];
            unset($_SESSION['password_modify']);
        }



        $this->tpl->view("authentication.html.twig" , ['error'=>$error,
                                                                'register_sent' => $register_sent,
                                                                'error_hash_pass' => $error_hash_pass,
                                                                'mail_reset' => $mail_reset,
                                                                'password_modify' => $password_modify]);
    }
    
    
    
}

