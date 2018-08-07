<?php

if(!isset($_SESSION["user"])){
    header("Location: ../../../DiaGenKri/public/home");
}

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

// SET USER MAIL
$userMail = $_SESSION['user'];
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
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css">

</head>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="logo-wrap">
                    <!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
                    <svg class="svg-link" version="1.1" height="35px" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                         viewBox="280 250 280 190" style="enable-background:new 0 0 841.9 595.3;" xml:space="preserve">
                        <a href="../../../DiaGenKri/public/home">
                        <g id="XMLID_1783_">
                            <text id="XMLID_1_" transform="matrix(1.244 0 0 1 291.3076 436.5898)" class="st0 st1 st2">ViDis</text>
                            <g id="XMLID_2190_">
                                <line id="XMLID_2192_" class="st3" x1="487.9" y1="375.4" x2="487.9" y2="391.2"/>
                                <line id="XMLID_2191_" class="st3" x1="477.3" y1="383.3" x2="498.6" y2="383.3"/>
                            </g>
                        </g>
                        <path id="XMLID_12_" class="st0" d="M538.7,315.5c-116.8,116.9-247.4,0-247.4,0S421.9,198.7,538.7,315.5z"/>
                        <ellipse id="XMLID_11_" class="st4" cx="418" cy="315.5" rx="53.2" ry="43.4"/>
                        <ellipse id="XMLID_10_" class="st0" cx="418" cy="315.5" rx="30" ry="24.5"/>
                        <g id="XMLID_14_">
                            <rect id="XMLID_22_" x="416.5" y="302.6" class="st4" width="3" height="25.9"/>
                            <rect id="XMLID_15_" x="405" y="314" class="st4" width="25.9" height="3"/>
                        </g>
                        </a>
                    </svg>
                </div>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION["user"]) && $_SESSION["user-admin"] == 1 || isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                <li><a href="../../../DiaGenKri/public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> Create algorithm</a></li>
                <?php endif; ?>
                <li><a href="../../../DiaGenKri/public/visualisation"><span class="glyphicon glyphicon-th"></span> List of algorithms</a></li>
                <?php if(isset($_SESSION["user"])): ?> <!-- && $_SESSION[user_level] === 6, which is admin for example-->
                    <?php if(isset($_SESSION["user-admin"]) && $_SESSION["user-admin"] == 1): ?>
                        <li><a href="../../../DiaGenKri/public/administrate"><span class="glyphicon glyphicon-cog"></span> Administrate</a></li>
                    <?php endif; ?>                <li class="dropdown">
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
                                <div class="row" id="login-row">
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
                                            <a href="../../../DiaGenKri/public/logIn/logOutUser/" class="btn btn-danger btn-block">Log out</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li><a href="../../../DiaGenKri/public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
                <li><a href="../../../DiaGenKri/public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
                <?php endif; ?>
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