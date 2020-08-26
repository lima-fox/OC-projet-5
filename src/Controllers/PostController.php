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

        $error_post = null;
        if(isset($_SESSION['error_post'])) {
            $error_post = $_SESSION['error_post'];
            unset($_SESSION['error_post']);
        }

        $error_login = null;
        if(isset($_SESSION['error_login'])) {
            $error_login = $_SESSION['error_login'];
            unset($_SESSION['error_login']);
        }

        $error_content = null;
        if(isset($_SESSION['error_content'])) {
            $error_content = $_SESSION['error_content'];
            unset($_SESSION['error_content']);
        }


        $this->tpl->view("billet.html.twig", ['post' => $post,
                                                        'comments' => $comments,
                                                        'error_post' => $error_post,
                                                        'error_login' => $error_login,
                                                        'error_content' => $error_content]);
        
    }

    public function list()
    {
        $posts = Post::getAll();

        $this->tpl->view("post.html.twig", ['posts' => $posts]);
    }


}
