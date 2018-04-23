<?php

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

}