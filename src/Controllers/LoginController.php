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
        $user = User::getByLogin($_POST['login']);
        $isPasswordCorrect = password_verify($_POST['pass'], $user->getPass());
        $active = $user->getActive();

        if($user != null AND $isPasswordCorrect AND $active == 1)
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
        $error_login = null;
        if(isset($_SESSION['error_login'])) {
            $error_login = $_SESSION['error_login'];
            unset($_SESSION['error_login']);
        }

        $error_login_exist = null;
        if(isset($_SESSION['error_login_exist'])) {
            $error_login_exist = $_SESSION['error_login_exist'];
            unset($_SESSION['error_login_exist']);
        }

        $error_firstname = null;
        if(isset($_SESSION['error_firstname'])) {
            $error_firstname = $_SESSION['error_firstname'];
            unset($_SESSION['error_firstname']);
        }

        $error_lastname = null;
        if(isset($_SESSION['error_lastname'])) {
            $error_lastname = $_SESSION['error_lastname'];
            unset($_SESSION['error_lastname']);
        }

        $error_mail = null;
        if(isset($_SESSION['error_mail'])) {
            $error_mail = $_SESSION['error_mail'];
            unset($_SESSION['error_mail']);
        }

        $error_phone = null;
        if(isset($_SESSION['error_phone'])) {
            $error_phone = $_SESSION['error_phone'];
            unset($_SESSION['error_phone']);
        }

        $error_pass = null;
        if(isset($_SESSION['error_pass'])) {
            $error_pass = $_SESSION['error_pass'];
            unset($_SESSION['error_pass']);
        }

        $this->tpl->view("register.html.twig", ['error_login' => $error_login,
                                                        'error_login_exist' => $error_login_exist,
                                                        'error_firstname' => $error_firstname,
                                                        'error_lastname' => $error_lastname,
                                                        'error_mail' => $error_mail,
                                                        'error_phone' => $error_phone,
                                                        'error_pass' => $error_pass]);
    }

    public function register_send()
    {
        $login = '';
        if (isset($_POST['login']))
        {
            if (strlen($_POST['login']) <4 )
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
            if (strlen($_POST['firstname']) < 2)
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
            if (strlen($_POST['lastname']) < 2)
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
        }
        else
        {
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

        $pass_hash = '';
        if (isset($_POST['pass']))
        {
            if (strlen($_POST['pass']) < 6)
            {
                $_SESSION['error_pass'] = 'Le mot de passe doit comporter au moins 6 caractères';
            }
            else
            {
                $pass = $_POST['pass'];
                $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            }
        }

        $hash = md5( rand(0,1000) );

        if ($login != '' AND $pass_hash != '' AND $lastname != '' AND $firstname != '' AND $email != '' AND $isPhoneValid == true  )
        {
            User::create($login, $pass_hash, $lastname, $firstname, $email, $phone, $hash);
            $_SESSION['register_sent'] = 1;

            $to      = $email; // Send email to our user
            $subject = 'Activez votre adresse mail'; // Give the email a subject
            $message = '
 
            Bonjour '.sprintf('%s %s', $firstname, $lastname).'  
            
            Votre compte a bien été enregistré, 
            
             
            Merci de cliquer sur le lien ci-dessous afin de l\'activer.
            http://blog5.test/verify/mail?hash='.$hash.'
             
            '; // Our message above including the link

            mail($to, $subject, $message); // Send our email

            header('Location: /seconnecter');
        }
        else
        {
            header('Location: /register');
        }


    }

    public function verify_mail()
    {
        if (!empty($_GET['hash']))
        {
            User::active_mail($_GET['hash']);
            $_SESSION['active_mail'] = 'Votre email est bien validé';
            header('Location: /seconnecter');
        }
        else
        {
            $_SESSION['error_hash'] = 'Impossible de valider votre email';
            header('Location: /seconnecter');
        }
    }

}