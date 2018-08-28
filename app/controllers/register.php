<?php

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 23. 03. 2018
 * Time: 10:13
 */

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class Register extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('register/index', ['name' => $user->name]);
    }

    public function add(){


        $validData = isset($_POST["name"]) && !empty($_POST["name"]) &&
            isset($_POST["surname"]) && !empty($_POST["surname"]) &&
            isset($_POST["email"]) && !empty($_POST["email"]) &&
            isset($_POST["password1"]) && !empty($_POST["password1"]) &&
            isset($_POST["password2"]) && !empty($_POST["password2"]);

        $_POST["name"] = htmlspecialchars($_POST["name"]);
        $_POST["surname"] = htmlspecialchars($_POST["surname"]);
        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["password1"] = htmlspecialchars($_POST["password1"]);
        $_POST["password2"] = htmlspecialchars($_POST["password2"]);


        if($_POST["password1"] != $_POST["password2"]){
            $validData = false;
        }



        if ($validData) {
            $key = DBfunctions::insert($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password1"]);

            if($key){
                var_dump($_POST["email"]);
                $response = $this->sendMail($_POST["email"], $key);
                if($response){
                    $_SESSION["mails-sent"] = 1;
                }
                else{
                    $_SESSION["mails-sent"] = 0;
                }

                ViewHelper::redirect('../../register/confirm');
            }
            else{
                ViewHelper::redirect('../../register');
            }
        } else {
            ViewHelper::redirect('../../register');
        }
        $_POST["name"] = "";
        $_POST["surname"] = "";
        $_POST["email"] = "";
        $_POST["password1"] = "";
        $_POST["password2"] = "";
    }

    public function confirm(){
        $this->view('register/confirm');
    }

    public function resend(){
        $_POST["email-resend"] = htmlspecialchars($_POST["email-resend"]);
        $key = DBfunctions::activationCode($_POST["email-resend"]);
        if($key != 0){
            if($_SESSION["mails-sent"] <3){
                $response = $this->sendMail($_POST["email-resend"], $key);
                if($response){
                    $_SESSION["mails-sent"] = 1;
                }
                else{
                    $_SESSION["errors"] = array();

                }
                $this->view('register/confirm');
            }
            else{

                $this->view('register/confirm');
            }
        }
    }

    public function sendMail($receiver, $key){
        $to      = $receiver; // Send email to our user
        $subject = 'Verification ViDis'; // Give the email a subject
        $message = '
 
Thank you for signing up!
Your account has been created, you can login with your credentials after you have activated your account by pressing the url below.

------------------------
 
Please click this link to activate your account:
http://localhost/public/register/confirm?email=' . $receiver . '&hash=' . $key . '

------------------------

If this registration was not done by you, please ignore the message.
Your personal information will be discarded automatically after 24 hours.

Please do not respond to this email address.

Your ViDis team
 
';

        $headers = 'From:support@vidis.fri.uni-lj.si' . "\r\n"; // Set from headers
        $response = mail($to, $subject, $message, $headers); // Send our email
        return $response;
    }

}