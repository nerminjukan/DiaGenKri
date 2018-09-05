<?php

/**
 * Created by PhpStorm.
 * User: Nermin
 * Date: 22. 03. 2018
 * Time: 12:17
 */

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
require_once("../app/core/ViewHelper.php");
class App{

    protected $controller = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct(){

        $url = $this->parseURL();
        

        if(file_exists('../app/controllers/' . $url[0] . '.php')){
            $this->controller = $url[0];
            unset($url[0]);
        }
        else{
            // TO DO
        }

        

        require_once '../app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
                // var_dump("true");
                // exit();

            }
            else{
                ViewHelper::redirect('..');
                ViewHelper::error404();
            }
        }
        else{
            // TO DO
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }


    public function parseURL(){
        if(isset($_GET['url'])){
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        else{
            // TO DO
        }
    }

}