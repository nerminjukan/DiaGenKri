<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>
<header class="col-12 spacing-increased">
    <h1>Home</h1>
</header>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">DiaGenKri</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php if(isset($_SESSION["user"])): ?>
                <li><a href="logIn/logOutUser/"><span class="glyphicon glyphicon-user"></span> Log out</a>
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