<?php

use App\User;

class Template
{
    private $twig;

    /**
     * @return \Twig\Environment
     */
    public function getTwig(): \Twig\Environment
    {
        return $this->twig;
    }


    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/../resources/views/');

        //'cache' => '../resources/cache/',
        $this->twig = new \Twig\Environment($loader, [

        ]);

        $user_id = null;
        $user_connected = null;
        if(isset($_SESSION['user_login']))
        {
            $user_id = $_SESSION['user_login'];
            $user_connected = User::getById($user_id);
        }
        $this->twig->addGlobal('user_connected', $user_connected);

    }
    
    public function view(string $template, array $parameters = []) 
    {
        echo $this->twig->render($template, $parameters);
    }
}



