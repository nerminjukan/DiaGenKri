<?php

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

// ENTER USER EMAIL PARAMETER FROM SESSION AS ARG
$data = DBfunctions::getUserProfile('nermin.jukan@mail.si');




?>

<!DOCTYPE html>
<html lang="sl">

<head>
    <title>Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>

<header class="col-12 spacing-increased">
    <h1>User profile</h1>
</header>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">DiaGenKri</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../../../DiaGenKri/public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
                <li><a href="../../../DiaGenKri/public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container text-center">
    <div class="row content">
        <div class="col-sm-4">
            <picture>
                <img class="row-increased-top img-responsive img-thumbnail" src="../../../DiaGenKri/app/res/photos/avatar.jpg" style="max-width: 50%">
            </picture>
        </div>
        <div class="col-sm-8 text-left">
            <table class="row-increased-top table table-bordered table-responsive table-striped">

                <tbody>
                <?php foreach ($data as $key => $value){
                    $name = $value["name"];
                    $surname = $value["surname"];
                    $email = $value["e-mail"];
                    $fow = $value["fieldofwork"];
                    $admin = $value["admin"];
                    $readPR = $value["readPR"];
                    $editPR = $value["editPR"];
                    $deletePR = $value["deletePR"];
                    $addPR = $value["addPR"];
                    $confirmPR = $value["confirmPR"];

                    if($fow == ""){
                        $fow = "-";
                    }

                    if($admin == 1){
                        $adminString = "admin, ";
                    }else{
                        $adminString = "";
                    }

                    if($readPR == 1){
                        $readString = "read, ";
                    }else{
                        $readString = "";
                    }

                    if($editPR == 1){
                        $editString = "edit, ";
                    }else{
                        $editString = "";
                    }

                    if($deletePR == 1){
                        $deleteString = "delete, ";
                    }else{
                        $deleteString = "";
                    }

                    if($addPR == 1){
                        $addString = "add, ";
                    }else{
                        $addString = "";
                    }

                    if($confirmPR == 1){
                        $confirmString = "confirm";
                    }else{
                        $confirmString = "";
                    }

                    echo "<tr><th class='th-st'>Name: </th><td>" . $name . "</td></tr>" .
                         "<tr><th class='th-st'>Surname: </th><td style=\"white-space: nowrap\">" . $surname . "</td></tr>" .
                         "<tr><th class='th-st'>E-mail: </th><td>" . $email . "</td></tr>" .
                         "<tr><th class='th-st'>Field of work: </th><td>" . $fow . "</td></tr>" .
                         "<tr><th class='th-st'>Administration rights: </th><td style=\"white-space: nowrap\">" . $adminString . $readString . $editString . $deleteString . $addString . $confirmString . "</td></tr>";

                }
                ?>
                </tbody>
            </table>
            <a href="../../../DiaGenKri/public/profile/edit" type="button" class="btn btn-info row-increased-bottom row-increased-top">Edit</a>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer>