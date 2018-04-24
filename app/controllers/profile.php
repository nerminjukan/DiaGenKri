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

    public function saveImage($name = ''){
        //print_r($_FILES);
        //phpinfo();
        if(move_uploaded_file ( $_FILES['name'], '../res/photos')){
            //$email = $_POST["userChange"];
            //unset($_POST["userChange"]);
            echo "JAAA";


            //DBfunctions::saveAdimistrationChanges($email, $_POST);

            //ViewHelper::redirect('../../public/profile');
        }
        else{
            echo "nOooo";
        }

    }

}