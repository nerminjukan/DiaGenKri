<?php
    if(isset($_SESSION["user"])){
        header("Location: ../../../DiaGenKri/public/home");
    }
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>
<header class="col-12 spacing-increased">
    <h1>Registration</h1>
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
                <li><a href="../../../DiaGenKri/public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>
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
            <div class="container-fluid row-increased-top">
                <form action = "<?= "register/add/" ?>" method = "post" content="">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type ="text" class="form-control" id="name" name ="name"/>
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname:</label>
                        <input type ="text" class="form-control" id="surname" name ="surname"/>
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input type = "email" class="form-control" id="email" name = "email"/>
                    </div>
                    <div class="form-group">
                        <label for="password1">Password:</label>
                        <input type="password" class="form-control" id="password1" name="password1"/>
                    </div>
                    <div class="form-group">
                        <label for="password2">Password (repeat):</label>
                        <input type="password" class="form-control" id="password2" name="password2"/>
                    </div>
                    <button class="btn btn-default row-increased-bottom" type="submit" value ="Oddaj">Submit</button>
                </form>
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