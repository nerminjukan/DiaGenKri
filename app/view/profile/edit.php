<?php

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

// TEMPORARY
$userMail = 'nermin.jukan@mail.si';
// ENTER USER EMAIL PARAMETER FROM SESSION AS ARG
$data = DBfunctions::getUserProfile($userMail);

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
                    <p class="row-increased-top">Select a PNG or JPEG image, having maximum size <span id="max-size"></span> KB.</p>
                    <form id="upload-image-form" action="saveImage" method="post" enctype="multipart/form-data">
                        <div id="image-preview-div" style="display: block">
                            <label for="exampleInputFile">Current image:</label>
                            <br>
                            <?php
                            if(file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpg")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".jpg";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPG")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".JPG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".png")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".png";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".PNG")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".PNG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpeg")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".jpeg";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPEG")){
                                $picture = "../../../DiaGenKri/app/res/photos/profilePhotos/" . $userMail . ".JPEG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            else{
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=\"../../../DiaGenKri/app/res/photos/avatar.jpg\" style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            ?>
                            <br>
                        </div>

                        <div class="form-group">
                            <input class="form-control" type="file" name="file" id="file" required>
                            <label hidden for="userMail"></label>
                            <input hidden type="text" id="userMail" name="userMail" <?php echo "value=" . $userMail;?>/>
                        </div>
                        <button class="btn btn-md btn-primary" id="upload-button" type="submit" disabled>Upload image</button>
                    </form>
                    <br>
                    <div class="alert alert-info" id="loading" style="display: none;" role="alert">
                        Uploading image...
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    <div id="message"></div>
        </div>
        <div class="col-sm-8 text-left form-group">
            <form action='saveUA' method='post'>
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

                        $_GET['email'] = $email;

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

                        echo "<tr><th class='th-st'>Name: </th><td>" .                                  "<div class=\"form-group\">
                                                                                                        <input type=\"text\" class=\"form-control\" id=\"name\" placeholder=" . $name . " name=\"name\">
                                                                                                        </div>" . "</td></tr>" . "</td></tr>" .

                            "<tr><th class='th-st'>Surname: </th><td style=\"white-space: nowrap\">" . "<div class=\"form-group\">
                                                                                                        <input type=\"text\" class=\"form-control\" id=\"surname\" placeholder=" . $surname . " name=\"surname\">
                                                                                                        </div>" . "</td></tr>" .

                            "<tr><th class='th-st'>E-mail: </th><td>" .                                 "<div class=\"form-group\">
                                                                                                        <input type=\"email\" class=\"form-control\" id=\"email\" placeholder=" . $email . " \"Enter email\" name=\"email\">
                                                                                                        </div>" . "</td></tr>" . "</td></tr>" .

                            "<tr><th class='th-st'>Field of work: </th><td>" .                          "<div class=\"form-group\">
                                                                                                        <input type=\"text\" class=\"form-control\" id=\"fow\" placeholder=" . $fow . " name=\"fow\">
                                                                                                        </div>" . "</td></tr>" . "</td></tr>" . "</td></tr>" .

                            "<tr><th class='th-st'>Administration rights: </th><td style=\"white-space: nowrap\">" . $adminString . $readString . $editString . $deleteString . $addString . $confirmString . "</td></tr>";

                    }
                    ?>
                    </tbody>
                </table>
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-success" name='userChange' <?php echo "value=" . $_GET['email']; ?>>Save</button>
                    <a href="../../../DiaGenKri/public/profile" type="button" class="btn btn-danger row-increased-bottom">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquerymin.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="../../../DiaGenKri/app/res/js/upload-image.js"></script>