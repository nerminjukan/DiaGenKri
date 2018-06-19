<?php

if(!isset($_SESSION["user"])){
    header("Location: ../../../DiaGenKri/public/home");
}
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Visualisation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../../../DiaGenKri/app/res/js/raphael/raphael.min.js"></script>

    <!---
        <script type="text/javascript" src="../../../DiaGenKri/app/res/js/david/raphael.pan-zoom.js"></script>
    --->

    <script type="text/javascript" src="../../../DiaGenKri/app/res/js/nermin/nermin.js"></script>

    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>
<header class="col-12 spacing-increased">
    <h1>Visualisation - david</h1>
</header>

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
                    <li><a href="../../../DiaGenKri/public/administrate"><span class="glyphicon glyphicon-cog"></span> Administrate</a></li>
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
                                        <div class="col-lg-4" id="login-size">
                                            <p class="text-center">
                                                <span class="glyphicon glyphicon-user icon-size"></span>
                                            </p>
                                        </div>
                                        <div class="col-lg-8" id="login-size">
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
                <?php else: ?>
                    <li><a href="../../../DiaGenKri/public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
                    <li><a href="../../../DiaGenKri/public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <h2>Toolbar</h2>
            <a ondragstart="startDrag(event)" draggable="true"  id="aSquare" href="javascript:void(0);" style="overflow: hidden; width: 40px; height: 40px; padding: 1px; display: inline-block; cursor: move">
                <svg class="draggable" id="svgtag"  style="width: 36px; height: 36px; display: block; position: relative; overflow: hidden; left: 2px; top: 2px">
                    <g>
                        <g></g>
                        <g>
                            <g transform="translate(2,10)" style="visibility: visible;">
                                <rect id="rectID"  class="draggable" height="16" width="31" fill="#ffffff" stroke="#000000" pointer-events="all"></rect>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
            <a ondragstart="startDrag(event)" draggable="true"  id="aLink" href="javascript:void(0);" style="overflow: hidden; width: 40px; height: 40px; padding: 1px; display: inline-block; cursor: move">
                <svg class="draggable" id="svgtag"  style="width: 36px; height: 36px; display: block; position: relative; overflow: hidden; left: 2px; top: 2px">
                    <g>
                        <g></g>
                        <g>
                            <g transform="translate(0.5,0.5)" style="visibility: visible;">
                                <line x1="5" y1="5" x2="30" y2="30" id="lineID" class="draggable" stroke="#000000" pointer-events="all"></line>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
            <a ondragstart="startDrag(event)" draggable="true"  id="aDecision" href="javascript:void(0);" style="overflow: hidden; width: 40px; height: 40px; padding: 1px; display: inline-block; cursor: move">
                <svg class="draggable" id="svgtag"  style="width: 36px; height: 36px; display: block; position: relative; overflow: hidden; left: 2px; top: 2px">
                    <g>
                        <g></g>
                        <g>
                            <g transform="translate(18, 8)" style="visibility: visible;">
                                <rect id="rhombusID" transform="rotate(45)" class="draggable" height="15" width="15" fill="#ffffff" stroke="#000000" pointer-events="all"></rect>
                            </g>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
        <div onclick="looseFocus(event)" ondrop="mainDraw(event)" class="col-sm-8" id="content">
            <div id="mapControls"><a id="up" href="javascript:void(0)"></a><a id="down" href="javascript:void(0)"></a></div>

        </div>
        <div class="col-sm-2 sidenav">
            <div class="well">
                <button onclick="addConnection()" id = "add_connection_button" class="btn btn-primary">add connection</button>
            </div>
            <h2>Settings</h2>
            <form>
                <label for="IDinput">Element ID</label>
                <input id="IDinput" disabled type="text" name="fname"><br>
                <label for="IDtext">Text</label>
                <input disabled onblur="setText()" id="IDtext" type="text">
            </form>
        </div>
    </div>
</div>

<footer class="container-fluid text-center fixed-bottom">
    <p>©DiaGenKri</p>
</footer>