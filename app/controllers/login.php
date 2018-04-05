<?php

session_start();

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class Login extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('login/index', ['name' => $user->name]);
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
                ?>
                <script type="text/javascript">console.log("login successful")</script>
                <?php
            }
            else{
                ?>
                <script type="text/javascript">console.log("login failed")</script>
                <?php
                ViewHelper::redirect('../../login');

            }
        } else {
            echo "NE DELA";
            ViewHelper::redirect('../../login');
        }
        $_POST["email"] = "";
        $_POST["password"] = "";
    }
}