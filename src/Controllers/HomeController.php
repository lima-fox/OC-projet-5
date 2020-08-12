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
    
    public function post()
    {
        $db = new \Database();
        $db->connect();
        //$posts = la liste des résultats
        $posts = $db->query('SELECT * ,DATE_FORMAT(`date`,"%d/%m/%Y à %Hh%imin%ss") AS date_post FROM posts ORDER BY `date` DESC LIMIT 5');

             
        //je passe ma ligne de résultat au template avec pour nom posts
        $this->tpl->view("post.html.twig", ['posts' => $posts]);
    }

    
}

