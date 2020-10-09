<?php


namespace App\Controllers;


use App\Comment;
use App\Post;
use App\User;

class AdminController
{
    protected $tpl;
    protected ?User $user_connected;

    public function __construct()
    {
        $this->tpl = new \Template();

        $globals = $this->tpl->getTwig()->getGlobals();

        if ($globals['user_connected'] != null) {
            $this->user_connected = $globals['user_connected'];
            if ($this->user_connected->getCategory() != 'admin') {
                http_response_code(403);
                die();
            }
        } else {
            http_response_code(403);
            die();
        }
    }

    public function admin()
    {
        $count_post = Post::count_post();
        $count_validated_comments = Comment::validated_comments();
        $count_pending_comments = Comment::pending_comments();
        $count_users = User::count_users();

        $this->tpl->view("/admin/starter.html.twig", ['count_post' => $count_post,
                                                                'count_validated_comments' => $count_validated_comments,
                                                                'count_pending_comments' => $count_pending_comments,
                                                                'count_users' => $count_users]);
    }
}