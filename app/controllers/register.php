<?php

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
            $res = DBfunctions::insert($_POST["name"], $_POST["surname"], $_POST["email"], $_POST["password1"]);
            if($res){
                ViewHelper::redirect('../../home');
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

}