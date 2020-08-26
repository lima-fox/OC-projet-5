<?php
namespace App\Controllers;

use App\Comment;
use App\Post;
use App\User;

class CommentController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function add_comment()
    {
        $post_id = 0;
        if(isset($_POST['post_id']))
        {
            $post_id = $_POST['post_id'];
            $post = Post::getById($post_id);
            if ($post == null)
            {
                $_SESSION['error_post'] = 'Le billet est invalide';
            }

        }

        $users_id = NULL;
        if(isset($_SESSION['user_login']))
        {
            $user = User::getById($_SESSION['user_login']);
            if ($user != null)
            {
                $users_id = $_SESSION['user_login'];
            }
            else
            {
                $_SESSION['error_login'] = 'Identifiant invalide';
            }
        }

        $content = '';
        if (isset($_POST['content']))
        {
            if (strlen($_POST['content']) > 10)
            {
                $content = $_POST['content'];
            }
            else
            {
                $_SESSION['error_content'] = 'Le message doit contenir au moins 10 caractères';
            }

        }

        if($post_id !=0 AND $users_id != NULL AND $content != '')
        {
            Comment::create($post_id, $users_id, $content);
        }

        header('Location: /billet?id=' . $post_id);
    }
}
