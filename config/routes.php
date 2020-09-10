<?php
include 'admin_routes.php';

use App\Controllers\CommentController;
use App\Controllers\HomeController;
use App\Controllers\ContactController;
use App\Controllers\LoginController;
use App\Controllers\PostController;

$uri = $_SERVER['REQUEST_URI'];

if ($uri == "/")
{
    $home = new HomeController();
    $home->index();
}
elseif ($uri == "/a-propos")
{
    $home = new HomeController();
    $home->apropos();
}
elseif ($uri == "/post")
{
    $home = new PostController();
    $home->list();
}
elseif (strpos($uri, "/billet") !== false)
{
    $home = new PostController();
    $home->billet();
}
elseif ($uri == "/comment/send")
{
    $home = new CommentController();
    $home->add_comment();
}
elseif ($uri == "/contact")
{
    $home = new ContactController();
    $home->contact();
}
elseif ($uri == "/contact/send")
{
    $send = new ContactController();
    $send->sendMessage(); 
}
elseif ($uri == "/seconnecter")
{
    $home = new HomeController();
    $home->auth();
}
elseif ($uri == "/login")
{
    $home = new LoginController();
    $home->connect();
}
elseif ($uri == "/disconnect")
{
    $home = new LoginController();
    $home->disconnect();
}
elseif ($uri == "/register/send")
{
    $home = new LoginController();
    $home->register_send();
}
