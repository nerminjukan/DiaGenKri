<?php






require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getGraphs();

//var_dump($data);
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
                <?php if(isset($_SESSION["user"]) &&  isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> Create algorithm</a></li>
                <?php endif; ?>
                <?php if(isset($_SESSION["user"]) && $_SESSION["user-confirm"] == 1): ?>
                    <li><a href="../../public/visualisation/curations"><span class="label label-pill label-danger count"></span> <span class="glyphicon glyphicon-bell" ></span> Curation requests</a></li>
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

<div class="well well-sm col-sm-12">
    <form name="gForm" role="form" class="form-inline" id="filterForm">
        <div class="well well-sm form-group filter-settings">
            <div class="form-group full-width">
                <label for="gName">Search:</label>
                <input onkeyup="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" type="email" class="form-control full-width" id="gName" placeholder="Enter algorithm name"
                style="width:100%;">
                <div>
                    <br><label for="gName">Curated:</label>
                    <label class="radio-inline" for="curated"><input onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" type="checkbox" id="curated" name="curated" value="0">Curated only</label>
                </div>
            </div>
            <!-- <div>
                <button type="button" onclick="resetFilters()" class="btn btn-sm btn-default full-width clear-filters">Clear filters</button>
            </div> -->
        </div>
        <div class="well well-sm form-group filter-settings">
            <label class="col-sm-6 control-label">Intended for:</label>

            <div class="col-sm-6">
                <?php if(isset($_SESSION["user"])): ?>
                <div>
                    <label class="radio-inline" for="typeDAll"><input onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" checked class="radio" type="radio" id="typeDAll" name="gType" value="all">All</label>
                </div>
                <?php endif; ?>
                <div>

                    <label class="radio-inline" for="typeVisual"><input onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" id="typeVisual" type="radio" name="gType" value="visual" <?php if(!isset($_SESSION["user"])): ?> checked="checked" <?php endif; ?> >Patients</label>
                </div>
                <?php if(isset($_SESSION["user"])): ?>
                <div>
                    <label class="radio-inline" for="typeDiagnostic"><input onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" type="radio" id="typeDiagnostic" name="gType" value="diagnostic">Doctors</label>
                </div>
                <?php endif; ?>


                <label style="color: red; font-size: 14px" id="typeLab"></label>
            </div>
        </div>
        <div class="well well-sm form-group filter-settings">
            <label class="col-sm-6 control-label">Algorithm type:</label>
            <div class="col-sm-6">
                <div>

                    <label class="radio-inline" for="typeADiagnostic"><input checked onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" type="checkbox" id="typeADiagnostic" name="aType" value="1">Diagnostic</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeATreatment"><input checked onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" id="typeATreatment" type="checkbox" name="aType" value="2">Treatment</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeAOther"><input checked onchange="filterTable('<?php if(isset($_SESSION["user"])){echo $_SESSION['user'];} ?>')" class="radio" type="checkbox" id="typeAOther" name="aType" value="4">Other</label>

                </div>
                <label style="color: red; font-size: 14px" id="typeLab"></label>
            </div>
        </div>

    </form>


    <!-- <div>
        <a class="btn btn-success" href="../../public/visualisation/editor">New graph</a>
    </div> -->

</div>


<div class="container-fluid">
    <div class="row content">
        <div class="col-lg-12 text-left">
            <table id="graphTable" class="table table-hover table-responsive table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Author</th>
                    <th>Algorithm name</th>
                    <th>Curated</th>
                    <th style="width: 100px;">Intended for</th>
                    <th>Algorithm type</th>

                    <?php if(isset($_SESSION["user"])): ?>
                    <th>Created</th>
                    <th>Edited</th>
                    <?php endif; ?>

                    <th>View</th>

                    <?php if(isset($_SESSION["user"])): ?>
                    <th>Edit</th>
                    <th>Delete</th>
                    <?php endif; ?>

                </tr>
                </thead>
                <tbody>
                <?php

                $ctr = 1;

                foreach ($data as $key => $value){
                    $id = $value["id"];
                    $email = $value["e-mail"];
                    $name = $value["name"];
                    $private = $value["private"];
                    $curated = $value["curated"];
                    $visual = $value["visual"];
                    $uname = $value["uname"];
                    $usurname = $value["usurname"];



                    $wholename = "";
                    if(isset($_SESSION["user"]) && isset($_SESSION["user-read"])){
                        $wholename = $uname . " " . $usurname . " - " . $email;
                    }
                    else{
                        $wholename = $uname . " " . $usurname;
                    }

                    if($curated === '0'){
                        $curated = 'No';
                    }
                    else{
                        $curated = 'Yes';
                    }

                    if($visual === '0'){
                        $visual = 'Patients';
                    }
                    else{
                        $visual = 'Doctors';
                    }

                    $algorithmType = $value["algorithm_type"];

                    if($algorithmType === '0') {
                        $algorithmType = '-';
                    }
                    else if($algorithmType === '1'){
                        $algorithmType = 'Diagnostic';
                    }
                    else if($algorithmType === '2'){
                        $algorithmType = 'Treatment';
                    }
                    else if($algorithmType === '3'){
                        $algorithmType = 'Diagnostic, treatment';
                    }
                    else if($algorithmType === '4'){
                        $algorithmType = 'Other';
                    }
                    else if($algorithmType === '5'){
                        $algorithmType = 'Diagnostic, other';
                    }
                    else if($algorithmType === '6'){
                        $algorithmType = 'Treatment, other';
                    }
                    else if($algorithmType === '7'){
                        $algorithmType = 'Diagnostic, treatment, other';
                    }

                    $created = $value["created-date"];
                    $edited = $value["edit-date"];

                    if($edited === null){
                        $edited = 'Not edited';
                    }

                    $tv = "View algorithm: $name";
                    $te = "Edit algorithm: $name";
                    $td = "Delete algorithm: $name";

                    $button_edit = "<button class='btn btn-block btn-primary edit-graph-button' id='$id'>Edit</button>";

                    if((!isset($_SESSION["user"]) ||  (isset($_SESSION["user-edit"]) && $_SESSION["user-edit"] != 1)) && (isset($_SESSION["user"]) && $_SESSION["user"] !== $email)){
                        $button_edit = "";
                        $te = "You do not have permission to edit this algorithm.";
                    }

                    $delete_alg = "<i id='$id' class='fa fa-times'></i>";

                    if((!isset($_SESSION["user"]) || (isset($_SESSION["user-delete"]) && $_SESSION["user-delete"] != 1)) && (isset($_SESSION["user"]) && $_SESSION["user"] !== $email)){
                        $delete_alg = "";
                        $td = "You do not have permission to delete this algorithm.";
                    }

                    $button_view = "<button class='btn btn-block btn-primary view-graph-button' id='$id'>View</button>";

                    if((!isset($_SESSION["user"]) || (isset($_SESSION["user-read"]) && $_SESSION["user-read"] != 1)) && (isset($_SESSION["user"]) && $_SESSION["user"] !== $email)){
                        $button_view = "";
                        $tv = "You do not have permission to view this algorithm.";
                    }

                    $output = "";

                    // doctors algorithms shouldnt be visible to public
                    if("$visual" === 'Patients' || isset($_SESSION["user"])){
                        // output string, start
                        $styleClass = " class='tr-graphTable'>";
                        if(isset($_SESSION["user"]) && $private === '1' && $_SESSION["user"] === $email){
                            $styleClass = "id='tr-private'>";
                        }
                        $output = "<tr " . $styleClass;

                        $output = "$output" . "<td>" . "$ctr" . "</td>";
                        $output = "$output" . "<td>" . "$wholename" . "</td>";
                        $output = "$output" . "<td>" . "$name" . "</td>";
                        $output = "$output" . "<td>" . "$curated" . "</td>";

                        // if("$visual" === 'Doctors')
                        //     if(isset($_SESSION["user"]))
                        //         $output = "$output" . "<td class='je-seja'>" . "$visual" . "</td>";
                        // else
                        $output = "$output" . "<td>" . "$visual" . "</td>";

                        $output = "$output" . "<td>" . "$algorithmType" . "</td>";

                        if(isset($_SESSION["user"])){
                            $output = "$output" . "<td title=\"dd. mm. yyyy\">" . "$created" . "</td>";
                            $output = "$output" . "<td title=\"dd. mm. yyyy\">" . "$edited" . "</td>";
                        }

                        $output = "$output" . "<td title='$tv'>" . "$button_view" . "</td>";

                        if(isset($_SESSION["user"])){
                            $output = "$output" . "<td title='$te'>" . "$button_edit" . "</td>";
                            $output = "$output" . "<td title='$td' class='center-me'>" . "$delete_alg" . "</td>";
                        }

                        $output = "$output" . "<td hidden>$private</td>" . "</tr>";

                    }

                    if((isset($_SESSION["user"]) && $private === '1' && $_SESSION["user"] === $email) || $private === '0'){
                        echo "$output";
                        $ctr++;
                    }
                }
                ?>
                
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->