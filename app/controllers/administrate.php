<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 13. 04. 2018
 * Time: 10:32
 */

require_once '../app/database/DBfunctions.php';
require_once("../app/core/ViewHelper.php");

class administrate extends Controller
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
}