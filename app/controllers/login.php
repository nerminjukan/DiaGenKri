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

    public function loginUser(){
        $validData = isset($_POST["email"]) && !empty($_POST["email"]) &&
                     isset($_POST["password"]) && !empty($_POST["password"]);

        $_POST["email"] = htmlspecialchars($_POST["email"]);
        $_POST["password"] = htmlspecialchars($_POST["password"]);


        if ($validData) {
            $result = DBfunctions::checkLogin($_POST["email"], $_POST["password"]);
            if($result){
                $_SESSION["user"] = $_POST["email"];
                echo isset($_SESSION["user"]);
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
}