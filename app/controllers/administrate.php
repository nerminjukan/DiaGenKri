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
    // set language
    require_once '../app/language/set_lang.php';
    require_once '../app/language/available_lang.php';
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

            // echo $email, $_POST;
            // var_dump($email, $_POST);
            // exit();

            $result = DBfunctions::saveAdimistrationChanges($email, $_POST);

            echo $result;
            // ViewHelper::redirect('../../public/administrate/change');
        }
        else{
            echo "0";
        }

    }
}