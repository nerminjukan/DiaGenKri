<?php

session_start();

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class LogIn extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

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

    public function loginUser(){
        $validData = isset($_POST["email"]) && !empty($_POST["email"]) &&
                     isset($_POST["password"]) && !empty($_POST["password"]);

        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["password"] = htmlspecialchars($_POST["password"]);

        // var_dump($_POST);
        // exit();


        if ($validData) {
            $result = DBfunctions::checkLogin($_POST["email"], $_POST["password"]);
            if($result){
                $_SESSION["user"] = $_POST["email"];

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
                ViewHelper::redirect('../../LogIn');

            }
        } else {
            echo "NE DELA";
            ViewHelper::redirect('../../LogIn');
        }
        $_POST["email"] = "";
        $_POST["password"] = "";
    }

    public function logOutUser(){
        session_destroy();
        ViewHelper::redirect('../../home');
    }
}