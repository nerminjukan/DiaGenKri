<?php

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

        $this->view('profile/edit', ['name' => $user->name]);
        //ViewHelper::redirect('../../public/profile');
    }

    public function saveUA($name = ''){
        if(isset($_POST["userChange"])){
            $email = $_POST["userChange"];
            //unset($_POST["userChange"]);

            print_r($_POST);

            //DBfunctions::saveAdimistrationChanges($email, $_POST);

            //ViewHelper::redirect('../../public/profile');
        }
        else{
            // TO DO
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
            $newName = $uploadDir . "user_" . $_POST['userMail'];
            $newName = rtrim($newName, '/');
            if(rename($uploadFile, $newName)){
                echo rtrim($_POST['userMail'], '/') . "<br>";
                echo $newName;
            }



            //DBfunctions::saveAdimistrationChanges($email, $_POST);

            //ViewHelper::redirect('../../public/profile/edit');
        }
        else{
            echo "nOooo";
        }

    }

}