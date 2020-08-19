<?php
use App\Controllers\HomeController;
use App\Controllers\ContactController;
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