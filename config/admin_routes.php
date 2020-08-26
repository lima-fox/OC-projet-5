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