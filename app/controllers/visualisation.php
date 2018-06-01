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

class visualisation extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;

        $this->view('visualisation/index', ['name' => $user->name]);
    }

}