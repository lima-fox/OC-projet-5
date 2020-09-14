<?php

use App\Controllers\AdminCommentController;
use App\Controllers\AdminPostController;
use App\Controllers\HomeController;


$uri = $_SERVER['REQUEST_URI'];

if ($uri == "/admin/dashboard")
{
$home = new HomeController();
$home->admin();
}
elseif ($uri == "/admin/comments")
{
$home = new AdminCommentController();
$home->getNotvalidated();
}
elseif (strpos($uri, "/admin/comments/validate") !== false)
{
    $home = new AdminCommentController();
    $home->validate();
}
elseif (strpos($uri, "/admin/comments/delete") !== false)
{
    $home = new AdminCommentController();
    $home->delete();
}
elseif ($uri == "/admin/post")
{
    $home = new AdminPostController();
    $home->add_post();
}
elseif ($uri == "/admin/post/send")
{
    $home = new AdminPostController();
    $home->create();
}
elseif ($uri == "/admin/posts_list")
{
    $home = new AdminPostController();
    $home->list();
}
elseif ($uri == "/admin/post_modify")
{
    $home = new AdminPostController();
    $home->modify_send();
}
elseif (strpos($uri, "/admin/post/modify") !== false)
{
    $home = new AdminPostController();
    $home->modify_form();
}
elseif (strpos($uri, "/admin/post/delete") !== false)
{
    $home = new AdminPostController();
    $home->delete();
}