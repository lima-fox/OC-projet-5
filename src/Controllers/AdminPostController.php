<?php


namespace App\Controllers;


use App\Post;

class AdminPostController extends AdminController
{
    public function add_post()
    {
        $error_title = null;
        if(isset($_SESSION['error_title'])) {
            $error_title = $_SESSION['error_title'];
            unset($_SESSION['error_title']);
        }

        $error_chapo = null;
        if(isset($_SESSION['error_chapo'])) {
            $error_chapo = $_SESSION['error_chapo'];
            unset($_SESSION['error_chapo']);
        }

        $error_text = null;
        if(isset($_SESSION['error_text'])) {
            $error_text = $_SESSION['error_text'];
            unset($_SESSION['error_text']);
        }

        $post_sent = 0;
        if(isset($_SESSION['post_sent'])) {
            $post_sent = $_SESSION['post_sent'];
            unset($_SESSION['post_sent']);
        }

        $this->tpl->view("/admin/form_post.html.twig", [
            'error_title' => $error_title,
            'error_chapo' => $error_chapo,
            'error_text' => $error_text,
            'post_sent' => $post_sent
        ]);
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


        if($title != '' AND $chapo != '' AND $text != '')
        {
            Post::create($title, $chapo, $text, $author);
            $_SESSION['post_sent'] = 1;
            header('Location: /admin/posts_list');
        }
        else
        {
            header('Location: /admin/post');
        }


    }

    public function list()
    {
        $post_sent = 0;
        if(isset($_SESSION['post_sent'])) {
            $post_sent = $_SESSION['post_sent'];
            unset($_SESSION['post_sent']);
        }

        $posts = Post::getAll();

        $this->tpl->view("/admin/posts.html.twig", ['posts' => $posts, 'post_sent'=> $post_sent]);
    }

    public function modify_send()
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


        if($title != '' AND $chapo != '' AND $text != '')
        {
            Post::modify($title, $chapo, $text, $_POST['post_id']);
            $_SESSION['post_update'] = 1;
            header('Location: /admin/posts_list');
        }
        else
        {
            header('Location: /admin/modify_form?id=' . $_POST['post_id']);
        }

    }

    public function modify_form()
    {
        $error_title = null;
        if(isset($_SESSION['error_title'])) {
            $error_title = $_SESSION['error_title'];
            unset($_SESSION['error_title']);
        }

        $error_chapo = null;
        if(isset($_SESSION['error_chapo'])) {
            $error_chapo = $_SESSION['error_chapo'];
            unset($_SESSION['error_chapo']);
        }

        $error_text = null;
        if(isset($_SESSION['error_text'])) {
            $error_text = $_SESSION['error_text'];
            unset($_SESSION['error_text']);
        }

        $post = Post::getById($_GET['id']);

        $this->tpl->view("/admin/post_modify.html.twig", [
            'post' => $post,
            'error_title' => $error_title,
            'error_chapo' => $error_chapo,
            'error_text' => $error_text
        ]);
    }

    public function delete()
    {
        Post::delete($_GET['id']);

        header('Location: /admin/posts_list');
    }
}