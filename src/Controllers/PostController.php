<?php
namespace App\Controllers;
use App\Comment;
use App\Post;
use App\User;

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
        $comments = Comment::getByPostId($_GET['id']);


        $this->tpl->view("billet.html.twig", ['post' => $post, 'comments' => $comments]);
        
    }

    public function list()
    {
        $posts = Post::getAll();

        $this->tpl->view("post.html.twig", ['posts' => $posts]);
    }


}
