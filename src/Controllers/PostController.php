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
        try
        {
            $bdd = new \PDO('mysql:host=localhost;dbname=blog5;charset=utf8', 'homestead', 'secret');
        }
        catch(Exception $e)
        {
            die('Erreur:' . $e->getMessage());
        }

        $post = $bdd->query('SELECT * ,DATE_FORMAT(`date`,"%d/%m/%Y à %Hh%imin%ss") AS date_post FROM posts WHERE id =' . $_GET['id']);
        $post1 = $post->fetch();
        
        $this->tpl->view("billet.html.twig", ['post' => $post1]);
        
    }
}
