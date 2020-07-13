<?php

class Template
{
    private $twig;
    
    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/../resources/views/');

        //'cache' => '../resources/cache/',
        $this->twig = new \Twig\Environment($loader, [

        ]);
    }
    
    public function view(string $template, array $parameters = array()) 
    {
        echo $this->twig->render($template, $parameters);
    }
}



