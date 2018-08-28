<?php

if(((!isset($_SESSION["user"])) || (!isset($_SESSION["user-confirm"]) || $_SESSION["user-confirm"] != 1))){
    header("Location: ../../public/visualisation");
}

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getCurations();

?>

<!DOCTYPE html>
<html lang="sl">

<head>
    <title>Graphs table</title>
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
    <script src="../../app/res/js/filter.js"></script>
    <script src="../../app/res/js/curations.js"></script>


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
                <?php if(isset($_SESSION["user"]) && $_SESSION["user-admin"] == 1 || isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                    <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> Create algorithm</a></li>
                <?php endif; ?>

                <?php if(isset($_SESSION["user-admin"]) && $_SESSION["user-admin"] == 1): ?>
                    <li><a href="../../public/administrate"><span class="glyphicon glyphicon-cog"></span> Administrate</a></li>
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

<div class="well well-sm col-sm-12 flex-wrap">
    <form name="gForm" role="form" class="form-inline" id="filterForm">
        <div class="well well-sm form-group filter-settings">
            <div class="form-group full-width">
                <label for="gName">Search:</label>
                <input onkeyup="filterTableCurations()" type="email" class="form-control full-width" id="gName" placeholder="Enter algorithm name"
                       style="width:100%;">
                <div>
                    <br><label for="curated">Status:</label>
                    <label class="radio-inline" for="curated"><input onchange="filterTableCurations()" class="radio" type="checkbox" id="curated" name="curated" value="0">Open requests only</label>
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
                    <th>ID</th>
                    <th>Algorithm name</th>
                    <th>Requested by</th>
                    <th>Request date</th>
                    <th>Status</th>
                    <th>Currated by</th>
                    <th>View</th>
                    <th>Curate</th>

                </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $key => $value){
                    $id = $value["id"];
                    $algorithmID = $value["graph-id"];
                    $algorithmName = $value["graph-name"];
                    $requestedByName = $value["name"];
                    $requestedBySurname = $value["surname"];
                    $requestedByWholeName = $requestedByName . " " . $requestedBySurname;
                    $requestedByMail = $value["requested-by"];
                    $requestDate = $value["formated-date"];
                    $status = $value["status"];
                    $curatedBy = $value["curated-by"];

                    if($status === '0'){
                        $status = 'Open';
                    }
                    else if($status === '1'){
                        $status = 'Closed - OK';
                    }
                    else{
                        $status = 'Closed - NOK';
                    }

                    if($curatedBy === null){
                        $curatedBy = 'Not currated';
                    }

                    $disabled = " ";

                    if($status === 'Closed - OK' || $status === 'Closed - NOK'){
                        $disabled = ' disabled title="Already curated" ';
                    }

                    $button_view = "<button class='btn btn-block btn-primary view-graph-button' id='$algorithmID'>View</button>";

                    $button_modal = "<button $disabled onclick='fillModal(event, this)' name='curate-$id' type=\"button\" class=\"btn btn-block btn-primary\" id='$id'>Curate</button>";

                    $style = "";
                    if($status === 'Open'){
                        $style = "style=\"background-color: #ffff66\"";
                    } else if($status === 'Closed - OK'){
                        $style = "style=\"background-color: #66ff66\"";
                    }
                    else{
                        $style = "style=\"background-color: #ff6666\"";
                    }

                    $output = "<tr>";

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