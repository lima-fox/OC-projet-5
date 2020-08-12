<?php
namespace App\Controllers;

class PostController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function billet()
    {
        $db = new \Database();
        $db->connect();

        $post = $db->query('SELECT * ,DATE_FORMAT(`date`,"%d/%m/%Y à %Hh%imin%ss") AS date_post FROM posts WHERE id =' . $_GET['id']);
        $post1 = $post->fetch();
        
        $this->tpl->view("billet.html.twig", ['post' => $post1]);
        
    }
}
