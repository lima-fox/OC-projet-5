<?php


namespace App\Controllers;


use App\Post;

class AdminPostController extends AdminController
{
    public function add_post()
    {
        $this->tpl->view("/admin/form_post.html.twig");
    }

    public function create()
    {
        $title = '';
        if (isset($_POST['title']))
        {
            if (strlen($_POST['title']) > 3)
            {
                $title = substr($_POST['title'], 0, 255);
            }
            else
            {
                $_SESSION['error_title'] = 'Le titre doit contenir au moins 3 caractères';
            }
        }

        $chapo = '';
        if (isset($_POST['chapo']))
        {
            if (strlen($_POST['chapo']) > 10)
            {
                $chapo = substr($_POST['chapo'], 0, 255);
            }
            else
            {
                $_SESSION['error_chapo'] = 'Le chapô doit contenir au moins 10 caractères';
            }
        }

        $text = '';
        if (isset($_POST['text']))
        {
            if (strlen($_POST['text']) > 30)
            {
                $text = $_POST['text'];
            }
            else
            {
                $_SESSION['error_text'] = 'Le post doit contenir au moins 30 caractères';
            }
        }

        $author = $this->user_connected->getId();

        var_dump($title);
        var_dump($chapo);
        var_dump($text);
        if($title != '' AND $chapo != '' AND $text != '')
        {
            Post::create($title, $chapo, $text, $author);
            $_SESSION['post_sent'] = 1;
        }

        //header('Location: /admin/post');

    }

    public function list()
    {
        $posts = Post::getAll();

        $this->tpl->view("/admin/posts.html.twig", ['posts' => $posts]);
    }
}