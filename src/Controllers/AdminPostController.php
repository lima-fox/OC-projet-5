<?php


namespace App\Controllers;


class AdminPostController
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

    public function add_post()
    {
        $this->tpl->view("/admin/form_post.html.twig");
    }
}