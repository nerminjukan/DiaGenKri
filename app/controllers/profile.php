<?php


$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}


require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 23. 04. 2018
 * Time: 18:54
 */
class profile extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('profile/index', ['name' => $user->name]);
    }

    public function edit($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        if(!isset($_SESSION["errors"])){
            $_SESSION["errors"] = array();
            $_SESSION["uname"] = null;
            $_SESSION["usurname"] = null;
            $_SESSION["sel1"] = null;
        }

        $this->view('profile/edit', ['name' => $user->name]);
        //ViewHelper::redirect('../../public/profile');
    }

    public function saveUA($name = ''){
        if(isset($_POST["userChange"])){

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
            if(!isset($_POST["sel1"]) || empty($_POST["sel1"])){
                $validData = false;
                $_SESSION["errors"]["fow"] = "You must select your field of work.";
            }

            $email = $_POST["userChange"];

            $_POST["name"] = htmlspecialchars($_POST["name"]);
            $_POST["surname"] = htmlspecialchars($_POST["surname"]);
            $_POST["sel1"] = htmlspecialchars($_POST["sel1"]);

            if($validData){
                $res = DBfunctions::saveProfileChanges($email, $_POST["name"], $_POST["surname"], $_POST["sel1"]);

                if($res){
                    ViewHelper::redirect('../../public/profile');
                }
                else{
                    $_SESSION["errors"] = array();
                    $_SESSION["errors"]["update-profile"] = "Could not update profile, try again later.";
                    ViewHelper::redirect('../../public/profile/edit');
                }
            }
            else{
                ViewHelper::redirect('../../public/profile/edit');
            }
        }
        else{
            $_SESSION["errors"] = array();
            $_SESSION["errors"]["no-user-mail"] = "Something went wrong, please try again later.";
            ViewHelper::redirect('../../public/profile/edit');
        }

    }

    // TO DO:
    // SAVE IMAGE PATH TO DB UNDER USER PROFILE TABLE
    // LOAD IMAGE PATH FROM DB AS SRC TO IMG BLOCK IN PROFILE VIEW (in /profile/index.php and /profile/edit.php)
    public function saveImage($name = ''){
        //print_r($_POST);
        $uploadDir = '../app/res/photos/profilePhotos/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        if(move_uploaded_file ( $_FILES['file']['tmp_name'], $uploadFile)){
            $format = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $newName = $uploadDir . $_POST['userMail'];
            $newName = rtrim($newName, '/');
            $newName = $newName . '.' . $format;
            if(rename($uploadFile, $newName)){
                echo rtrim($_POST['userMail'], '/') . "<br>";
                echo $newName;
            }

            ViewHelper::redirect('../../public/profile/edit');
        }
        else{
            echo "nOooo";
        }

    }

}