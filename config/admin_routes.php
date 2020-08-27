<?php

use App\Controllers\AdminCommentController;
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