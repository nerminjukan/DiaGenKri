<?php

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getUserData();




?>

<!DOCTYPE html>
<html lang="sl">

<head>
    <title>Administration</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>

<header class="col-12 spacing-increased">
    <h1>User administration</h1>
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

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-left">
                <table class="table table-hover table-responsive table-striped">
                    <thead>
                    <tr style="text-align: center">
                        <th>User</th>
                        <th>E-mail</th>
                        <th style="width: auto">Privileges</th>
                    </tr>
                    </thead>
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

                        if($admin == 1){
                            $adminString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\">
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Admin</label>
</div> | ";
                        }else{
                            $adminString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Admin</label>
</div> | ";
                        }

                        if($readPR == 1){
                            $readString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Read</label>
</div> | ";
                        }else{
                            $readString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Read</label>
</div> | ";
                        }

                        if($editPR == 1){
                            $editString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Edit</label>
</div> | ";
                        }else{
                            $editString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Edit</label>
</div> | ";
                        }

                        if($deletePR == 1){
                            $deleteString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Delete</label>
</div> | ";
                        }else{
                            $deleteString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Delete</label>
</div> | ";
                        }

                        if($addPR == 1){
                            $addString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Add</label>
</div> | ";
                        }else{
                            $addString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Add</label>
</div> | ";
                        }

                        if($confirmPR == 1){
                            $confirmString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Confirm</label>
</div>";
                        }else{
                            $confirmString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" >
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Confirm</label>
</div>";
                        }

                        echo "<tr><td>$name $surname</td><td>$email</td><td>$fow</td><td style=\"white-space: nowrap; width: 50%\"><form class='form-inline'>" . $adminString . $readString . $editString . $deleteString . $addString . $confirmString . "</form></td></tr>";

                    }
                    ?>
                    </tbody>
                </table>


            <div class="btn-group col-md-3">
                <a href="../../../DiaGenKri/public/administrate/save" type="button" class="btn btn-success row-increased-bottom">Save</a>
                <a href="../../../DiaGenKri/public/administrate" type="button" class="btn btn-danger row-increased-bottom">Cancel</a>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer>