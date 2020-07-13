<?php
namespace App\Controllers;

use \libphonenumber\PhoneNumberUtil;
use \libphonenumber\NumberParseException;

class ContactController
{
    private $tpl;

    public function __construct()
    {
        $this->tpl = new \Template();
    }

    public function contact()
    {

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

        $error_name = null;
        if(isset($_SESSION['error_name'])) {
            $error_name = $_SESSION['error_name'];
            unset($_SESSION['error_name']);
        }

        $error_text = null;
        if(isset($_SESSION['error_text'])) {
            $error_text = $_SESSION['error_text'];
            unset($_SESSION['error_text']);
        }

        $email_sent = 0;
        if(isset($_SESSION['email_sent'])) {
            $email_sent = $_SESSION['email_sent'];
            unset($_SESSION['email_sent']);
        }

        $this->tpl->view("contact.html.twig", [
            'error_mail' => $error_mail, 
            'error_phone' => $error_phone, 
            'email_sent' => $email_sent,
            'error_name' => $error_name,
            'error_text' => $error_text
            ]
        );
        

    }
    
    public function sendMessage()
    {
        
        $has_error = false;
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error_mail'] = 'Adresse mail non valide';
            $has_error = true;
        }

        if ($_POST['name'] == '')
        {
            $_SESSION['error_name'] = 'Veuillez indiquer votre nom';
            $has_error = true;
        }

        if ($_POST['message'] == '')
        {
            $_SESSION['error_text'] = 'Veuillez remplir le champ message';
            $has_error = true;
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
            $has_error = true;
        }

        if( !$isPhoneValid ) 
        {
            $_SESSION['error_phone'] = 'Numéro de téléphone non valide';
            $has_error = true;
        }
         
        if ($has_error)
        {
           header('Location: /contact');
        }
        else
        {        
            //formate ton $message
            $message = "Nom: " . $_POST['name'] . "\n" . "Mail expéditeur: " .  $_POST['email'] . "\n" . "Numéro de téléphone:" .  $_POST['phone'] . "\n\n" . $_POST['message']; 

            $success = mail('lucile.fremont@gmail.com', 'test', $message);
            if (!$success) {
                $errorMessage = error_get_last()['message'];
            }
            $_SESSION['email_sent'] = 1;
            //redirige vers /contact avec message email envoye
            header('Location: /contact');
            
        }
        

        
        
    }
}