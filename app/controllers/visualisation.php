<?php

$status = session_status();
if($status == PHP_SESSION_NONE){
    //There is no active session
    session_start();
}
/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 8. 05. 2018
 * Time: 16:41
 */

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class Visualisation extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/index', ['name' => $user->name]);
    }

    public function editor($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/editor', ['name' => $user->name]);
    }

    public function viewonly($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/view', ['name' => $user->name]);
    }

    public function delete() {
        $result = 0;
        if(isset($_SESSION["user"]) && isset($_POST["id"]))
            $result = DBfunctions::deleteGraph($_SESSION["user"], $_POST['id']);
        
        echo $result;
    }

    public function edit(){
        if(isset($_SESSION["user"]) && isset($_POST["data"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["gtype"]) && isset($_POST["atype"]) && isset($_POST["id"])){


            DBfunctions::editGraph($_SESSION["user"], $_POST["data"], $_POST["name"], $_POST["description"], $_POST["gtype"], $_POST["atype"],
                $_POST["id"]);

            // ViewHelper::redirect('../../public/visualisation/gallery');
        }
    }

    public function load(){
        // echo "hello world";
        $result = DBfunctions::loadGraph($_POST['id']);
        // echo "<pre>";
        // var_dump($result);
        // exit();
        echo json_encode($result);
    }

    public function save(){

        //var_dump($_POST);

        if(isset($_SESSION["user"]) && isset($_POST["data"]) && isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["gtype"]) && isset($_POST["atype"])){


            DBfunctions::saveGraph($_SESSION["user"], $_POST["data"], $_POST["name"], $_POST["description"], $_POST["gtype"], $_POST["atype"]);

            // ViewHelper::redirect('../../public/visualisation/gallery');
        }
        else{
            // TO DO
        }



    }

    public function diagnosis(){
        $this->view('visualisation/diagnosis');
    }

    public function gallery($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/gallery', ['name' => $user->name]);
    }

}