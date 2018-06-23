<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css">

</head>

<div class="box">
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
                    <li><a href="../../../DiaGenKri/public/visualisation"><span class="glyphicon glyphicon-pencil"></span> Visualisation</a></li>
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
                <h3>LINKS</h3>
                <p><a href="http://www.limfom-levkemija.org/domov.html">L&L</a></p>
            </div>
            <div class="col-sm-8 text-left">
                <h1>Welcome</h1>
                <p>This website is dedicated to visualising algorithms for genetic disease diagnosis.</p>
                <hr>
                <h3>What would you like to do?</h3>
                <div class="col-sm-4 row-increased-top">
                    <a href="#" title=""><img src="../../../DiaGenKri/app/res/photos/sample.jpg" class="img-responsive img-thumbnail"></a>
                </div>
                <div class="col-sm-4 row-increased-top">
                    <a href="#" title=""><img src="../../../DiaGenKri/app/res/photos/sample.jpg" class="img-responsive img-thumbnail"></a>
                </div>
                <div class="col-sm-4 row-increased-top">
                    <a href="#" title=""><img src="../../../DiaGenKri/app/res/photos/sample.jpg" class="img-responsive img-thumbnail"></a>
                </div>
                
            </div>
            <div class="col-sm-2 sidenav">
                <div class="well">
                    <p>ADS</p>
                </div>
                <div class="well">
                    <p>ADS</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="container-fluid text-center">
        <p>©DiaGenKri</p>
    </footer>
</div>