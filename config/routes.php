<?php
use App\Controllers\HomeController;
use App\Controllers\ContactController;

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
    $home = new HomeController();
    $home->post();
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