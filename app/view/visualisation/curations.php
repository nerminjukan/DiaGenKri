<?php

if(((!isset($_SESSION["user"])) || (!isset($_SESSION["user-confirm"]) || $_SESSION["user-confirm"] != 1))){
    header("Location: ../../public/visualisation");
}
// include language array
if(file_exists('../app/language/lang/lang_' . $_SESSION["lang"] . '.php'))
    require_once '../app/language/lang/lang_' . $_SESSION["lang"] . '.php';
else
    require_once '../app/language/lang/lang_en.php';
require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getCurations();

?>

<!DOCTYPE html>
<html lang="<?php echo $lang["lang"]?>">

<head>
    <title><?php echo $lang["curations_title"]?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- jquery, popper.js and bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!-- additional javascript and stylesheets -->
    <link rel="stylesheet" href="../../app/res/css/main.css">
    <script src="../../app/res/js/david/notify.min.js"></script>

    <script src="../../app/res/js/david/edit.js"></script>


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
                            echo "<li><a href=../../public/visualisation/curations?lang=$value>$value</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <?php if(isset($_SESSION["user"]) &&  isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                    <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> <?php echo $lang["algorithm_create"]; ?></a></li>
                <?php endif; ?>
                <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span> <?php echo $lang["algorithm_list"]; ?></a></li>
                <?php if(isset($_SESSION["user-admin"]) && $_SESSION["user-admin"] == 1): ?>
                    <li><a href="../../public/administrate"><span class="glyphicon glyphicon-cog"></span> <?php echo $lang["user_administrate"]; ?></a></li>
                <?php endif; ?>
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
                                            <p id="user-mail-id" class="text-left small"><?php
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
                    <li><a href="../../public/register"><span class="glyphicon glyphicon-log-in"></span> <?php echo $lang["user_register"]; ?></a></li>
                    <li><a href="../../public/logIn"><span class="glyphicon glyphicon-user"></span> <?php echo $lang["user_log_in"]; ?></a></li>

                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="well well-sm col-sm-12 flex-wrap">
    <form name="gForm" role="form" class="form-inline" id="filterForm">
        <div class="well well-sm form-group filter-settings">
            <div class="form-group full-width">
                <label for="gName"><?php echo $lang['curations_search']; ?></label>
                <input onkeyup="filterTableCurations()" type="email" class="form-control full-width" id="gName" placeholder="<?php echo $lang['curations_search_h']; ?>"
                       style="width:100%;">
                <div>
                    <br><label for="curated"><?php echo $lang['curations_status']; ?></label>
                    <label class="radio-inline" for="curated"><input onchange="filterTableCurations()" checked class="radio" type="checkbox" id="curated" name="curated" value="0"><?php echo $lang['curations_status_s']; ?></label>
                </div>
            </div>
        </div>


    </form>


    <!-- <div>
        <a class="btn btn-success" href="../../public/visualisation/editor">New graph</a>
    </div> -->

</div>


<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12 text-left flex-wrap">
            <table id="curationTable" class="table table-hover table-responsive table-bordered">
                <thead>
                <tr>
                    <th><?php echo $lang['curations_id']; ?></th>
                    <th><?php echo $lang['curations_an']; ?></th>
                    <th><?php echo $lang['curations_rb']; ?></th>
                    <th><?php echo $lang['curations_rd']; ?></th>
                    <th><?php echo $lang['curations_st']; ?></th>
                    <th><?php echo $lang['curations_cb']; ?></th>
                    <th><?php echo $lang['curations_v']; ?></th>
                    <th><?php echo $lang['curations_c']; ?></th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $key => $value){

                    // curation request ID
                    $id = $value["id"];

                    // algorithm id
                    $algorithmID = $value["graph-id"];

                    $algorithmName = $value["graph-name"];
                    $requestedByName = $value["name"];
                    $requestedBySurname = $value["surname"];
                    $requestedByWholeName = $requestedByName . " " . $requestedBySurname;
                    $requestedByMail = $value["requested-by"];
                    $requestDate = $value["formated-date"];
                    $status = $value["status"];
                    $curatedBy = $value["curated-by"];

                    $ctr = 1;

                    if($status === '0'){
                        $status = $lang['curations_s-o'];
                    }
                    else if($status === '1'){
                        $status = $lang['curations_s-cok'];
                    }
                    else{
                        $status = $lang['curations_s-cnok'];
                    }

                    if($curatedBy === null){
                        $curatedBy = $lang['curations_nc'];
                    }

                    $disabled = " ";

                    if($status === $lang['curations_s-cok'] || $status === $lang['curations_s-cnok']){
                        $disabled = ' disabled title=\''.$lang['curations_allc'] . '\'';
                    }

                    $button_view = "<button class='btn btn-block btn-primary view-graph-button' id='$algorithmID'>".$lang['curations_v']."</button>";

                    $button_modal = "<button $disabled onclick='fillModal(event, this)' name='curate-$id' type=\"button\" class=\"btn btn-block btn-primary\" id='$id'>".$lang['curations_c']."</button>";

                    $style = "";
                    if($status === $lang['curations_s-o']){
                        $style = "style=\"background-color: #ffff66\"";
                    } else if($status === $lang['curations_s-cok']){
                        $style = "style=\"background-color: #66ff66\"";
                    }
                    else{
                        $style = "style=\"background-color: #ff6666\"";
                    }

                    if($status === $lang['curations_s-o']){
                        $output = "<tr>";
                    }
                    else{
                        $output = "<tr style='display: none'>";
                    }


                    $output = "$output" . "<td>" . "$id" . "</td>";

                    $output = "$output" . "<td>" . "$algorithmName" . "</td>";
                    $output = "$output" . "<td>" . "$requestedByWholeName" . ": " . "$requestedByMail" . "</td>";
                    $output = "$output" . "<td title=\"dd. mm. yyyy\">" . "$requestDate" . "</td>";
                    $output = "$output" . "<td title=\"Request status\" $style>" . "$status" . "</td>";
                    $output = "$output" . "<td>" . "$curatedBy" . "</td>";
                    $output = "$output" . "<td>" . "$button_view" . "</td>";
                    $output = "$output" . "<td>" . "$button_modal" . "</td>";

                    echo "$output";


                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal CURATE -->
<div id="makeModal">
</div>

<p hidden id="user-full-name"><?php echo $_SESSION["user-name"] . ' ' . $_SESSION["user-surname"]; ?></p>

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->
<script src="../../app/res/js/curations.js"></script>
<script src="../../app/res/js/filter.js"></script>