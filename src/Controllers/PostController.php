<?php
namespace App\Controllers;
use App\Post;

class PostController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function billet()
    {
        $post = Post::getById($_GET['id']);

        $this->tpl->view("billet.html.twig", ['post' => $post]);
        
    }

    public function list()
    {
        $posts = Post::getAll();

        $this->tpl->view("post.html.twig", ['posts' => $posts]);
    }
}
