<?php

if(!isset($_SESSION["user"]) || $_SESSION["user-admin"] != 1){
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
                    <?php if(isset($_SESSION["user"])): ?>
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

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-12 text-left">
            <table class="table table-sc table-hover table-responsive table-striped">
                <thead>
                <tr class="tr-sc" style="text-align: center">
                    <th>User</th>
                    <th>E-mail</th>
                    <th style="width: auto">Privileges</th>
                </tr>
                </thead>
                <tbody class="tbody-sc">
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
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Admin</label>
</div> | ";
                    }else{
                        $adminString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Admin</label>
</div> | ";
                    }

                    if($readPR == 1){
                        $readString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Read</label>
</div> | ";
                    }else{
                        $readString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Read</label>
</div> | ";
                    }

                    if($editPR == 1){
                        $editString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Edit</label>
</div> | ";
                    }else{
                        $editString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Edit</label>
</div> | ";
                    }

                    if($deletePR == 1){
                        $deleteString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Delete</label>
</div> | ";
                    }else{
                        $deleteString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Delete</label>
</div> | ";
                    }

                    if($addPR == 1){
                        $addString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Add</label>
</div> | ";
                    }else{
                        $addString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Add</label>
</div> | ";
                    }

                    if($confirmPR == 1){
                        $confirmString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" checked=\"checked\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Confirm</label>
</div>";
                    }else{
                        $confirmString = "<div class=\"form-check form-check-inline form-group check-box-spacing\">
  <input class=\"form-check-input\" type=\"checkbox\" id=\"inlineCheckbox1\" value=\"option1\" disabled>
  <label class=\"form-check-label active\" for=\"inlineCheckbox1\">Confirm</label>
</div>";
                    }

                    echo "<tr class='tr-sc'><td style=\"white-space: nowrap; width: 25%\">$name $surname</td><td>$email</td><td style=\"white-space: nowrap; width: 50%\"><form class='form-inline'>" . $adminString . $readString . $editString . $deleteString . $addString . $confirmString . "</form></td></tr>";

                }
                ?>
                </tbody>
            </table>
            <button type="button" class="btn btn-info row-increased-bottom row-increased-top" data-toggle="modal" data-target="#editModal">Change</button>
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