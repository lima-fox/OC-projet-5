<?php


namespace App\Controllers;


use App\Comment;


class AdminCommentController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();

        $globals = $this->tpl->getTwig()->getGlobals();

        if ($globals['user_connected'] != null)
        {
            $user_connected = $globals['user_connected'];
            if ($user_connected->getCategory() != 'admin')
            {
                http_response_code(403);
                die();
            }
        }
        else
        {
            http_response_code(403);
            die();
        }
    }

    public function getNotValidated()
    {
        $comments = Comment::getNotValidated();

        $this->tpl->view("/admin/comments.html.twig", ['comments' => $comments]);
    }

    public function validate()
    {
        Comment::validate($_GET['id']);

        header('Location: /admin/comments');
    }

    public function delete()
    {
        Comment::delete($_GET['id']);

        header('Location: /admin/comments');
    }
}