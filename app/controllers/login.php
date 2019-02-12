<?php

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
    // set language
    require_once '../app/language/set_lang.php';
    require_once '../app/language/available_lang.php';
}

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class LogIn extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        if(!isset($_SESSION["errors"])){
            $_SESSION["errors"] = array();
            $_SESSION["umail"] = null;
            $_SESSION["passw"] = null;
        }

        $this->view('LogIn/index', ['name' => $user->name]);
    }

    private function storeCookie() {
        $rememberKey = hash('sha512',openssl_random_pseudo_bytes(50));
        $stmt = $db->prepare("INSERT INTO sessions (user_id,remember_key) VALUES (:user_id,:remember_key)");
        $stmt->bindParam(":user_id",$dbId);
        $stmt->bindParam(":remember_key",$rememberKey);
        $stmt->execute();
        setcookie ('rememberMe[0]', $dbId, time() + (86400 * 365), "/");
        setcookie ('rememberMe[1]', $rememberKey, time() + (86400 * 365), "/");    
    }

    // get name of user with that email and display it at login
    public function getNameOfUser($email){

    }

    public function loginUser(){
        $_SESSION["errors"] = array();

        $validData = true;

        if(!isset($_POST["email"]) || empty($_POST["email"])){
            $validData = false;
            $_SESSION["errors"]["email"] =  "You must provide your E-mail address.";
        }
        if(!isset($_POST["password"]) || empty($_POST["password"])){
            $validData = false;
            $_SESSION["errors"]["password"] = "You must provide your password.";
        }

        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["password"] = htmlspecialchars($_POST["password"]);


        if ($validData) {
            $result = DBfunctions::checkLogin($_POST["email"], $_POST["password"]);
            if($result){
                $_SESSION["user"] = $_POST["email"];

                // get name of that user
                $data = DBfunctions::getUser($_POST["email"]);
                // var_dump("dumping in login", $name[0]);
                // exit();
                $_SESSION["user-name"] = $data['name'];
                $_SESSION["user-surname"] = $data['surname'];
                $_SESSION["user-admin"] = $data['admin'];
                $_SESSION["user-read"] = $data['readPR'];
                $_SESSION["user-edit"] = $data['editPR'];
                $_SESSION["user-delete"] = $data['deletePR'];
                $_SESSION["user-add"] = $data['addPR'];
                $_SESSION["user-confirm"] = $data['confirmPR'];

                // check if user is remembered
                if (!empty($_POST["remember-me"])){
                    setcookie("email", $_POST["email"], time() + (7 * 24 * 60 * 60), "/");
                    setcookie("password", $_POST["password"], time() + (7 * 24 * 60 * 60), "/");
                } else {
                    setcookie("email", $_POST["email"], 1, "/");
                    setcookie("password", $_POST["password"], 1, "/");
                }
                ViewHelper::redirect('../../home');
            }
            else{
                $_SESSION["errors"]["login"] = "Login access denied, incorrect login information.";
                ViewHelper::redirect('../../LogIn');

            }
        }
        else {
            $_SESSION["uemail"] = $_POST["email"];
            ViewHelper::redirect('../../LogIn');
        }
        $_POST["email"] = "";
        $_POST["password"] = "";
    }

    public function logOutUser(){
        session_unset();  
        session_destroy();
        ViewHelper::redirect('../../home');
    }
}
