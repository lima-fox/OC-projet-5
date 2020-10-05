<?php
namespace App\Controllers;
use App\PasswordResets;
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

    public function reset_password_form()
    {
        $mail_reject = null;
        if(isset($_SESSION['mail_reject'])) {
            $mail_reject = $_SESSION['mail_reject'];
            unset($_SESSION['mail_reject']);
        }

        $mail_empty = null;
        if(isset($_SESSION['mail_empty'])) {
            $mail_empty = $_SESSION['mail_empty'];
            unset($_SESSION['mail_empty']);
        }

        $this->tpl->view("password_reset_form.html.twig", ['mail_reject' => $mail_reject,
                                                                    'mail_empty' => $mail_empty]);

    }

    public function reset_password_send()
    {

        if (!empty($_POST['mail']))
        {
            $user = User::getByMail($_POST['mail']);
            $active = $user->getActive();
            $firstname = $user->getFirstname();
            $lastname = $user->getLastname();
            if ($active == 1)
            {
                $hash = substr(md5(time()), 0, 16);
                PasswordResets::create($user->getId(), $_POST['mail'], $hash);

                $to      = $_POST['mail']; // Send email to our user
                $subject = 'Reinitialiser votre mot de passe'; // Give the email a subject
                $message = '
 
            Bonjour '.sprintf('%s %s', $firstname, $lastname).'  
            
                      
             
            Merci de cliquer sur le lien ci-dessous pour réinitialiser votre mot de passe
            http://blog5.test/reset_password/init?hash='.$hash.'
             
            '; // Our message above including the link

                mail($to, $subject, $message); // Send our email
                $_SESSION['mail_reset'] = 'L\'email de réinitialisation de votre mot de passe a bien été envoyé';
                header('Location: /seconnecter');
            }
            else
            {
                $_SESSION['mail_reject'] = 'Votre adresse mail doit être active afin de réinitialiser votre mot de passe';
                header('Location: /reset_password/form');
            }
        }
        else
        {
            $_SESSION['mail_empty'] = 'Merci d\'entrer une adresse mail valide';
            header('Location: /reset_password/form');
        }

    }

    public function new_password_form()
    {
        if (!empty($_GET['hash']))
        {
            $error_pass = null;
            if(isset($_SESSION['error_pass'])) {
                $error_pass = $_SESSION['error_pass'];
                unset($_SESSION['error_pass']);
            }
            $error_pass2 = null;
            if(isset($_SESSION['error_pass2'])) {
                $error_pass2 = $_SESSION['error_pass2'];
                unset($_SESSION['error_pass2']);
            }

            $hash_pass = $_GET['hash'];
            $user = User::getByHashPass($hash_pass);


            $this->tpl->view("new_password.html.twig", ['user' => $user,
                                                                'error_pass' => $error_pass,
                                                                'error_pass2' => $error_pass2]);
        }
        else
        {
            $_SESSION['error_hash_pass'] = 'Impossible de réinitialiser votre mot de passe';
            header('Location: /seconnecter');
        }


    }

    public function new_password_send()
    {

        $pass = '';
        $pass2 = $_POST['pass2'];
        $pass_hash = '';
        $user_id = $_POST['user_id'];
        if (isset($_POST['pass']))
        {
            if (strlen($_POST['pass']) < 6)
            {
                $_SESSION['error_pass'] = 'Le mot de passe doit comporter au moins 6 caractères';
            }
            else
            {
                $pass = $_POST['pass'];
            }
        }

        if ($pass == $pass2)
        {
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        }
        else
        {
            $_SESSION['error_pass2'] = 'Les 2 mots de passe ne sont pas identique';
        }

        if ($pass_hash != '')
        {
            PasswordResets::modify_password($user_id, $pass_hash);
            $_SESSION['password_modify'] = 'Votre mot de passe a bien été changé';
            header('Location: /seconnecter');
        }
        else
        {
            header(" Location: /reset_password/init?hash=".$_GET['hash']) ;
        }

    }

}