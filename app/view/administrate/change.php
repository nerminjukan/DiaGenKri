<?php

if(!isset($_SESSION["user"]) && $_SESSION["user-admin"] != 1){
    header("Location: ../../../DiaGenKri/public/home");
}

require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getUsersData();


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
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css">

    <script type="text/javascript" src="../../../DiaGenKri/app/res/js/david/notify.min.js"></script>
    <script type="text/javascript" src="../../../DiaGenKri/app/res/js/david/permissions.js"></script> 


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

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12 text-left flex-wrap" style="margin-bottom: 0">
            <a href="../../../DiaGenKri/public/administrate" type="button" class="btn btn-primary row-increased-bottom row-increased-top" style="width: 100%; max-width: 960px;">Done</a>
        </div>
       <!--  <div class="col-sm-12 text-left flex-wrap" style="margin-bottom: 0; margin-top: 0">
            <a href="../../../DiaGenKri/public/administrate" type="button" class="btn btn-danger row-increased-bottom" style="width: 100%; max-width: 960px;">Cancel</a>
        </div> -->
        <div class="col-sm-12 text-left flex-wrap">
            <table id="graphTable" class="table table-hover table-responsive table-bordered" style="margin-top: 0px;">
                <thead>
                <tr>
                    <th>User</th>
                    <th>E-mail</th>
                    <th>Privileges</th>
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

                    $adminString = "<div class='flex-div'><input type='checkbox' id='admin"."$i'";
                    if($admin == 1)
                        $adminString = $adminString . " checked='checked' ";
                    $adminString = $adminString . "><label for='admin"."$i'>admin</label></input></div>";

                    $readString = "<div class='flex-div'><input type='checkbox' id='read"."$i'";
                    if($readPR == 1)
                        $readString = $readString . " checked='checked' ";
                    $readString = $readString . "><label for='read"."$i'>read</label></input></div>";

                    $editString = "<div class='flex-div'><input type='checkbox' id='edit"."$i'";
                    if($editPR == 1)
                        $editString = $editString . " checked='checked' ";
                    $editString = $editString . "><label for='edit"."$i'>edit</label></input></div>";

                    $deleteString = "<div class='flex-div'><input type='checkbox' id='delete"."$i'";
                    if($deletePR == 1)
                        $deleteString = $deleteString . " checked='checked' ";
                    $deleteString = $deleteString . "><label for='delete"."$i'>delete</label></input></div>";

                    $addString = "<div class='flex-div'><input type='checkbox' id='add"."$i'";
                    if($addPR == 1)
                        $addString = $addString . " checked='checked' ";
                    $addString = $addString . "><label for='add"."$i'>add</label></input></div>";

                    $confirmString = "<div class='flex-div'><input type='checkbox' id='confirm"."$i'";
                    if($confirmPR == 1)
                        $confirmString = $confirmString . " checked='checked' ";
                    $confirmString = $confirmString . "><label for='confirm"."$i'>confirm</label></input></div>";


                    // $privileges = "<form class='form-inline' action='savePR' method='post'>";
                    // $privileges = $privileges . $adminString . $readString . $editString . $deleteString . $addString . $confirmString; 
                    $privileges = $adminString . $readString . $editString . $deleteString . $addString . $confirmString; 

                    $button = "<button type='button' class='btn btn-primary save-permissions' name='$i' id='$email'>Save</button>";
                    // output string, start
                    $output = "<tr class='tr-graphTable'>";

                    $output = "$output" . "<td style='width: 25%;'>" . "$name" . " " . "$surname" . "</td>";
                    $output = "$output" . "<td style='width: 25%;'>" . "$email" . "</td>";
                    $output = "$output" . "<td class='flex-cell'>" . $privileges . $button . "</td>";
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

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->