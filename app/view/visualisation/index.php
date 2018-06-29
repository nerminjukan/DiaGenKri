<?php

if(!isset($_SESSION["user"])){
    header("Location: ../../../DiaGenKri/public/home");
}


require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getGraphs();

?>

<!DOCTYPE html>
<html lang="sl">

<head>
    <title>Gallery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>


<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="../../../DiaGenKri/public/home">DiaGenKri</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION["user"])): ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="glyphicon glyphicon-user"></span> 
                            <strong><?php
                                echo $_SESSION["user-name"];
                                ?>
                            </strong>
                            <span class="glyphicon glyphicon-chevron-down"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <div class="navbar-login">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <p class="text-center">
                                                <span class="glyphicon glyphicon-user icon-size"></span>
                                            </p>
                                        </div>
                                        <div class="col-lg-8">
                                            <p class="text-left"><strong><?php
                                                    echo $_SESSION["user-name"] . " " . $_SESSION["user-surname"];
                                                    ?>
                                                </strong></p>
                                            <p class="text-left small"><?php
                                                echo $_SESSION["user"];
                                                ?>
                                            </p>
                                            <p class="text-left">
                                                <a href="../../../DiaGenKri/public/profile" class="btn btn-primary btn-block btn-sm">My profile</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <div class="navbar-login navbar-login-session">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <p>
                                                <a href="logIn/logOutUser/" class="btn btn-danger btn-block">Log out</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div>
    FILTER
    <div>
        <a class="btn btn-success" href="../../../DiaGenKri/public/visualisation/editor">New graph</a>
    </div>
</div>


<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12 text-left">
            <table class="table table-hover table-responsive table-striped">
                <thead>
                <tr style="text-align: center">
                    <th>ID</th>
                    <th>Author</th>
                    <th>Graph name</th>
                    <th>Graph type</th>
                    <th>Algorithm type</th>
                    <th>Created</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody class="tbody">
                <?php foreach ($data as $key => $value){
                    $id = $value["id"];
                    $email = $value["e-mail"];
                    $name = $value["name"];
                    $visual = $value["visual"];
                    $algorithmType = $value["algorithm_type"];
                    $created = $value["created"];
                    $button = "<form action=\"visualisation/edit\" method=\"get\">
                                <input hidden type=\"text\" value='$id' name=\"id\"><br>
                                <input class='btn btn-block btn-primary' value='Edit' type=\"submit\">
                                </form>";

                    echo "<tr><td>$id</td><td>$email</td><td>$name</td><td>$visual</td><td>$algorithmType</td><td>$created</td><td>$button</td></tr>";

                }
                ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Administration warning</h4>
                    </div>
                    <div class="modal-body">
                        <p>You are about to enter the page for changing user privileges. Please proceed with caution, as changes to user rights may affect the content of the application. Do you wish to continue?</p>
                    </div>
                    <div class="modal-footer">
                        <a href="../../../DiaGenKri/public/administrate/change" class="btn btn-warning row-increased-bottom btn-block">Yes, continue</a>
                        <button class="btn btn-info row-increased-bottom btn-block" data-dismiss="modal">No, cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer>