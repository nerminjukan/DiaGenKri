<?php
/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 13. 04. 2018
 * Time: 10:32
 */

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class Administrate extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('administrate/index', ['name' => $user->name]);
    }

    public function change($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('administrate/change', ['name' => $user->name]);
    }

    public function savePR($name = ''){
        if(isset($_POST["userChange"])){
            $email = $_POST["userChange"];
            unset($_POST["userChange"]);

            DBfunctions::saveAdimistrationChanges($email, $_POST);

            ViewHelper::redirect('../../public/administrate/change');
        }
        else{
            // TO DO
        }

    }
}