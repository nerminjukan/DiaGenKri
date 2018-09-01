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

        if(!isset($_SESSION["errors"])){
            $_SESSION["errors"] = array();
            $_SESSION["uname"] = null;
            $_SESSION["usurname"] = null;
            $_SESSION["usemail"] =  null;
            $_SESSION["sel1"] = null;
        }

        $this->view('register/index', ['name' => $user->name]);
    }

    public function add(){

        $validData = true;

        $_SESSION["errors"] = array();

        if(!isset($_POST["name"]) || empty($_POST["name"])){
            $validData = false;
            $_SESSION["errors"]["name"] =  "You must provide your name.";
        }
        if(!isset($_POST["surname"]) || empty($_POST["surname"])){
            $validData = false;
            $_SESSION["errors"]["surname"] = "You must provide your surname.";
        }
        if(!isset($_POST["email"]) || empty($_POST["email"])){
            $validData = false;
            $_SESSION["errors"]["email"] = "You must provide your E-mail address.";
        }
        if($_POST["password1"] != $_POST["password2"] || empty($_POST["password1"]) || empty($_POST["password2"])){
            $validData = false;
            if(!isset($_POST["password1"]) || empty($_POST["password1"])){
                $validData = false;
                $_SESSION["errors"]["password1"] = "You must provide a password.";
            }
            else if(!isset($_POST["password2"]) || empty($_POST["password2"])){
                $validData = false;
                $_SESSION["errors"]["password2"] = "You must repeat your password.";
            }
            else{
                $_SESSION["errors"]["password-mismatch"] = "The provided passwords do not match, please try again.";
            }
        }
        if(!isset($_POST["sel1"]) || empty($_POST["sel1"])){
            $validData = false;
            $_SESSION["errors"]["fow"] = "You must select your field of work.";
        }

        $_POST["name"] = htmlspecialchars($_POST["name"]);
        $_POST["surname"] = htmlspecialchars($_POST["surname"]);
        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["password1"] = htmlspecialchars($_POST["password1"]);
        $_POST["password2"] = htmlspecialchars($_POST["password2"]);
        $_POST["sel1"] = htmlspecialchars($_POST["sel1"]);

        $_SESSION["uname"] = null;
        $_SESSION["usurname"] = null;
        $_SESSION["usemail"] =  null;
        $_SESSION["sel1"] = null;

        if ($validData) {
            $key = DBfunctions::insert($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password1"], $_POST["sel1"]);

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
            $_SESSION["uname"] = $_POST["name"];
            $_SESSION["usurname"] = $_POST["surname"];
            $_SESSION["usemail"] = $_POST["email"];
            $_SESSION["sel1"] = $_POST["sel1"];
            ViewHelper::redirect('../../register');
        }
        $_POST["name"] = "";
        $_POST["surname"] = "";
        $_POST["email"] = "";
        $_POST["password1"] = "";
        $_POST["password2"] = "";
        $_POST["sel1"] = "";
    }

    public function confirm(){
        $this->view('register/confirm');
    }

    public function resend(){
        if(!isset($_SESSION["errors"])){
            $_SESSION["errors"] = array();
        }

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
                $_SESSION["errors"]["mailerror"] =  "You have reached the re-send limit. Please try again later.";
                $this->view('register/confirm');
            }
        }else{
            $_SESSION["errors"]["mailerror"] =  "The provided E-mail address is not registered in the system.";
            ViewHelper::redirect('../../register');
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