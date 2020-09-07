<?php


namespace App\Controllers;


use App\Comment;


class AdminCommentController extends AdminController
{

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