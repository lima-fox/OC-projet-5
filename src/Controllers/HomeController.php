<?php
namespace App\Controllers;



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
        $this->tpl->view("index.html.twig");
    }
    
    
    
}

