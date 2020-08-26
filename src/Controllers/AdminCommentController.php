<?php


namespace App\Controllers;


use App\Comment;
use App\User;

class AdminCommentController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function getNotValidated()
    {
        $comments = Comment::getNotValidated();

        $this->tpl->view("/admin/comments.html.twig", ['comments' => $comments]);
    }
}