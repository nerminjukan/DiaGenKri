<?php

if(!isset($_SESSION["user"]) || $_SESSION["user-admin"] != 1){
    header("Location: ../../public/home");
    // include language array
}
if(file_exists('../app/language/lang/lang_' . $_SESSION["lang"] . '.php'))
    require_once '../app/language/lang/lang_' . $_SESSION["lang"] . '.php';
else
    require_once '../app/language/lang/lang_en.php';

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getUsersData();

?>

<!DOCTYPE html>
<html lang="<?php echo $lang["lang"]?>">

<head>
    <title><?php echo $lang['administrate_title']?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../app/res/css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">



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
                <li class="dropdown"><a id="myLanId" class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-sign-language"></i> <?php echo $_SESSION["lang"]; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($_SESSION["available_languages"] as $key => $value) {
                            if ($value == $_SESSION["lang"])
                                continue;
                            echo "<li><a href=../../public/administrate?lang=$value>$value</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <?php if(isset($_SESSION["user"]) && isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span><?php echo $lang["algorithm_create"]; ?></a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION["user"]) && $_SESSION["user-confirm"] == 1): ?>
                    <li><a href="../../public/visualisation/curations"><span class="label label-pill label-danger count"></span> <span class="glyphicon glyphicon-bell" ></span> <?php echo $lang["algorithm_curation_request"]; ?></a></li>
                <?php endif; ?>
                <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span><?php echo $lang["algorithm_list"]; ?></a></li>
                <?php if(isset($_SESSION["user"])): ?> <!-- && $_SESSION[user_level] === 6, which is admin for example-->
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
                                    <div class="row" id="login-row">
                                        <div class="col-lg-4 image">
                                            <p class="text-center">
                                                <?php
                                                $userMail = $_SESSION["user"];
                                                if(file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpg")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".jpg";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".JPG";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".png")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".png";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".PNG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".PNG";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpeg")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".jpeg";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPEG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".JPEG";
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
                                                <a href="../../public/profile" class="btn btn-primary btn-block btn-sm"><?php echo $lang["profile_link"]; ?></a>
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
                                                <a href="../../public/logIn/logOutUser/" class="btn btn-danger btn-block"><?php echo $lang["user_log_out"]; ?></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="../../public/register"><span class="glyphicon glyphicon-log-in"></span><?php echo $lang["user_register"]; ?></a></li>
                    <li><a href="../../public/logIn"><span class="glyphicon glyphicon-user"></span> <?php echo $lang["user_log_in"]; ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12 text-left" style="margin-bottom: 0">
            <button type="button" class="btn btn-primary row-increased-bottom row-increased-top" data-toggle="modal" data-target="#editModal" style="width: 100%;"><?php echo $lang['administrate_edit-privileges-btn']?></button>
        </div>
        <div class="col-sm-12 text-left table-responsive">
            <table id="graphTable" class="table table-hover table-bordered" style="margin-top: 0px;">
                <thead>
                <tr>
                    <th><?php echo $lang['administrate_user']?></th>
                    <th><?php echo $lang['administrate_email']?></th>
                    <th><?php echo $lang['administrate_privileges']?></th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
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

                    $adminString = "<div class='flex-div'><input disabled type='checkbox' id='admin"."$i'";
                    if($admin == 1)
                        $adminString = $adminString . " checked='checked' ";
                    $adminString = $adminString . "><label for='admin"."$i'>".$lang['administrate_admin']."</label></input></div>";

                    $readString = "<div class='flex-div'><input disabled type='checkbox' id='read"."$i'";
                    if($readPR == 1)
                        $readString = $readString . " checked='checked' ";
                    $readString = $readString . "><label for='read"."$i'>".$lang['administrate_read']."</label></input></div>";

                    $editString = "<div class='flex-div'><input disabled type='checkbox' id='edit"."$i'";
                    if($editPR == 1)
                        $editString = $editString . " checked='checked' ";
                    $editString = $editString . "><label for='edit"."$i'>".$lang['administrate_edit']."</label></input></div>";

                    $deleteString = "<div class='flex-div'><input disabled type='checkbox' id='delete"."$i'";
                    if($deletePR == 1)
                        $deleteString = $deleteString . " checked='checked' ";
                    $deleteString = $deleteString . "><label for='delete"."$i'>".$lang['administrate_delete']."</label></input></div>";

                    $addString = "<div class='flex-div'><input disabled type='checkbox' id='add"."$i'";
                    if($addPR == 1)
                        $addString = $addString . " checked='checked' ";
                    $addString = $addString . "><label for='add"."$i'>".$lang['administrate_add']."</label></input></div>";

                    $confirmString = "<div class='flex-div'><input disabled type='checkbox' id='confirm"."$i'";
                    if($confirmPR == 1)
                        $confirmString = $confirmString . " checked='checked' ";
                    $confirmString = $confirmString . "><label for='confirm"."$i'>".$lang['administrate_confirm']."</label></input></div>";


                    $privileges = $adminString . $readString . $editString . $deleteString . $addString . $confirmString;
                    // output string, start
                    $output = "<tr class='tr-graphTable'>";

                    $output = "$output" . "<td style='width: 25%;'>" . "$name" . " " . "$surname" . "</td>";
                    $output = "$output" . "<td style='width: 25%;'>" . "$email" . "</td>";
                    $output = "$output" . "<td class='flex-cell'>" . $privileges . "</td>";
                    // end
                    $output = "$output" . "</tr>";

                    echo "$output";

                    //
                    $i++;
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="editModal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $lang['administrate_warning-title']?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $lang['administrate_modal-body']?></p>
            </div>
            <div class="modal-footer">
                <a href="../../public/administrate/change" class="btn btn-warning row-increased-bottom btn-block"><?php echo $lang['administrate_change-confirm-btn']?></a>
                <button class="btn btn-primary row-increased-bottom btn-block" data-dismiss="modal"><?php echo $lang['administrate_change-reject-btn']?></button>
            </div>
        </div>
    </div>
</div>

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->
<script src="../../app/res/js/curations.js"></script>
