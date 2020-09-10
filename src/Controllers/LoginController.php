<?php
namespace App\Controllers;
use App\User;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class LoginController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function connect()
    {

        $user = User::verify($_POST['login'], $_POST['pass']);

        if($user != null)
        {
            $_SESSION['user_login'] = $user->getId();
            header('Location: /');
        }
        else
        {
            $_SESSION['error'] = "Identifiant ou mot de passe incorrect";
            header('Location: /seconnecter');
        }

    }

    public function disconnect()
    {
        unset($_SESSION['user_login']);
        header('Location: /');
    }

    public function register_form()
    {
        $this->tpl->view("register.html.twig" );
    }

    public function register_send()
    {
        $login = '';
        if (isset($_POST['login']))
        {
            if (strlen($_POST['login'] < 4))
            {
                $_SESSION['error_login'] = 'le login doit comporter au moins 4 caractères';
            }
            else
            {
                $count_login = User::count_login($_POST['login']);
                if ($count_login > 0)
                {
                    $_SESSION['error_login_exist'] = 'ce login existe deja';
                }
                else
                {
                    $login = $_POST['login'];
                }
            }
        }

        $firstname = '';
        if (isset($_POST['firstname']))
        {
            if (strlen($_POST['firstname'] < 2))
            {
                $_SESSION['error_firstname'] = 'Le prénom doit comporter au moins 2 caractères';
            }
            else
            {
                $firstname = $_POST['firstname'];
            }
        }

        $lastname = '';
        if (isset($_POST['lastname']))
        {
            if (strlen($_POST['lastname'] < 2))
            {
                $_SESSION['error_lastname'] = 'Le nom de famille doit comporter au moins 2 caractères';
            }
            else
            {
                $lastname = $_POST['lastname'];
            }
        }

        $email = '';
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error_mail'] = 'Adresse mail non valide';
            $email = $_POST['email'];
        }

        $phone = $_POST['phone'];
        $phoneUtil = PhoneNumberUtil::getInstance();
        $isPhoneValid = false;
        try {
            $NumberProto = $phoneUtil->parse($phone, "FR");
            $isPhoneValid = $phoneUtil->isValidNumber($NumberProto);
        }
        catch (NumberParseException $e)
        {
            $_SESSION['error_phone'] = 'Numéro de téléphone non valide';
        }

        if( !$isPhoneValid )
        {
            $_SESSION['error_phone'] = 'Numéro de téléphone non valide';
        }
    }

}