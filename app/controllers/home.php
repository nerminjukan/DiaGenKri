<?php

session_start();

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 23. 03. 2018
 * Time: 10:12
 */
class Home extends Controller
{
    public function index($name = ''){
        $user = $this->model('User');
        $user->name = $name;
        
        $this->view('home/index', ['name' => $user->name]);
    }

}