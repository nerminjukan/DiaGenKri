<?php

if(!isset($_SESSION["user"])){
    header("Location: ../../public/home");
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
    <link rel="stylesheet" href="../../app/res/css/main.css">
    <script src="../../app/res/js/curations.js"></script>
    <script src="../../app/res/js/upload-image.js"></script>


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
                        <a href="../../public/home">
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
                <?php if(isset($_SESSION["user"]) && isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> Create algorithm</a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION["user"]) && $_SESSION["user-confirm"] == 1): ?>
                    <li><a href="../../public/visualisation/curations"><span class="label label-pill label-danger count"></span> <span class="glyphicon glyphicon-bell" ></span> Curation requests</a></li>
                <?php endif; ?>
                <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span> List of algorithms</a></li>
                <?php if(isset($_SESSION["user"])): ?> <!-- && $_SESSION[user_level] === 6, which is admin for example-->
                    <?php if(isset($_SESSION["user-admin"]) && $_SESSION["user-admin"] == 1): ?>
                        <li><a href="../../public/administrate"><span class="glyphicon glyphicon-cog"></span> Administrate</a></li>
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
                                    <div class="col-lg-4 image">
                                        <p class="text-center">
                                            <?php
                                            $userMail = $_SESSION["user"];
                                            if(file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpg")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".jpg";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPG")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".JPG";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".png")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".png";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".PNG")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".PNG";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpeg")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".jpeg";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPEG")){
                                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".JPEG";
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                            }
                                            else{
                                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=\"../../app/res/photos/avatar.jpg\" style=\"max-width: 50%\">";
                                            }
                                            ?>
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
                                            <a href="../../public/profile" class="btn btn-primary btn-block btn-sm">My profile</a>
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
                                            <a href="../../public/logIn/logOutUser/" class="btn btn-danger btn-block">Log out</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li><a href="../../public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
                <li><a href="../../public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
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
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".jpg";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPG")){
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".JPG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".png")){
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".png";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".PNG")){
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".PNG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpeg")){
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".jpeg";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPEG")){
                                $picture = "../../app/res/photos/profilePhotos/" . $userMail . ".JPEG";
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 50%\" id=\"preview-img\">";
                            }
                            else{
                                echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=\"../../app/res/photos/avatar.jpg\" style=\"max-width: 50%\" id=\"preview-img\">";
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

                        $rights = "";
                        if($admin == 1){
                            $rights = $rights .  "Admin";
                        }

                        if($readPR == 1){
                            if($rights === ""){
                                $rights = $rights . "Read";
                            }
                            $rights = $rights . ", " . "read";
                        }

                        if($readPR == 1){
                            if($rights === ""){
                                $rights = $rights . "Edit";
                            }
                            $rights = $rights . ", " . "edit";
                        }

                        if($readPR == 1){
                            if($rights === ""){
                                $rights = $rights . "Delete";
                            }
                            $rights = $rights . ", " . "delete";
                        }

                        if($readPR == 1){
                            if($rights === ""){
                                $rights = $rights . "Add";
                            }
                            $rights = $rights . ", " . "add";
                        }

                        if($readPR == 1){
                            if($rights === ""){
                                $rights = $rights . "Confirm";
                            }
                            $rights = $rights . ", " . "confirm";
                        }
                        $rights = $rights . ".";

                        $select = "<div class=\"form - group\">
                        <div>
                            <select required class=\"form-control\" id=\"sel1\" name=\"sel1\">
                                <option disabled hidden>Choose your field of work</option>";
                        $opt1 = "<option value=\"Doctor\" id=\"opt1\">Doctor</option>";
                        $opt2 = "<option value=\"Scientist\" id=\"opt2\">Scientist</option>";
                        $opt3 = "<option value=\"Researcher\" id=\"opt3\">Researcher</option>";
                        $opt4 = "<option value=\"Other\" id=\"opt4\">Other</option>";
                        if($fow === "doctor"){
                            $opt1 = "<option selected value=\"doctor\" id=\"opt1\">Doctor</option>";
                        }
                        else if($fow === "scientist"){
                            $opt2 = "<option selected value=\"scientist\" id=\"opt2\">Scientist</option>";
                        }
                        else if($fow === "researcher"){
                            $opt3 = "<option selected value=\"researcher\" id=\"opt3\">Researcher</option>";
                        }
                        else{
                            $opt4 = "<option selected value=\"other\" id=\"opt4\">Other</option>";
                        }

                        $selectEnd =     "</select></div></div>";

                        $select = $select . $opt1 . $opt2 . $opt3 . $opt4 . $selectEnd;

                        $output =  "<tr><th class='th-st'>Name: </th><td>" .                                  "<div class=\"form-group\">
                                                                                                        <input type=\"text\" class=\"form-control\" id=\"name\" placeholder=" . $name . " value=" . $name . " name=\"name\">
                                                                                                        </div>" . "</td></tr>" . "</td></tr>" .

                            "<tr><th class='th-st'>Surname: </th><td style=\"white-space: nowrap\">" . "<div class=\"form-group\">
                                                                                                        <input type=\"text\" class=\"form-control\" id=\"surname\" placeholder=" . $surname . " value=" . $surname . " name=\"surname\">
                                                                                                        </div>" . "</td></tr>" .

                            "<tr><th class='th-st'>E-mail: </th><td>" .                                 "<div class=\"form-group\">
                                                                                                        <input type=\"email\" disabled title='You cannot change your E-mail address.' class=\"form-control\" id=\"email\" placeholder=" . $email . " \"Enter email\" name=\"email\">
                                                                                                        </div>" . "</td></tr>" . "</td></tr>" .

                            "<tr><th class='th-st'>Field of work: </th><td>" .

                            $select .

                            "<tr><th class='th-st'>Administration rights: </th><td style=\"white-space: nowrap\">" . $rights . "</td></tr>";

                        echo $output;
                    }
                    ?>
                    </tbody>
                </table>
                <div class="btn-group col-md-3">
                    <button type="submit" class="btn btn-success" name='userChange' <?php echo "value=" . $_GET['email']; ?>>Save</button>
                    <a href="../../public/profile" type="button" class="btn btn-danger row-increased-bottom">Cancel</a><br>
                </div>
                <div>
                    <?php
                    try{
                        if(isset($_SESSION["errors"])){
                            foreach ($_SESSION["errors"] as $key => $value){

                                echo "<span style=\"color: red\" id=\"errors\">$value</span><br>";
                            }
                            $_SESSION["errors"] = null;
                        }
                    } catch (Exception $e){

                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->
