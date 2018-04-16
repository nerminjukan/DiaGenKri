<?php
    if(isset($_SESSION["user"])){
        header("Location: ../../../DiaGenKri/public/home");
    }
?>
<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Log in</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css"

</head>
<header class="col-12 spacing-increased">
    <h1>Log in</h1>
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
                <li><a href="../../../DiaGenKri/public/home"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="../../../DiaGenKri/public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
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
            <div>
                <article>
                    <div align = "center">
                        <div style = "width:300px; margin-top: 0.8em" align = "left">
                            <form action = "<?= "logIn/loginUser/" ?>" method = "post" content="">
                                <div class="form-group">
                                <label for="login-email">E-pošta</label>
                                <input type="email" name = "email" class="form-control" id="login-email" aria-describedby="emailHelp" placeholder="e-poštni naslov" value="<?php if(isset($_COOKIE["email"])){echo $_COOKIE["email"];} ?>">
                                <label for="login-password" style="margin-top: 0.8em">Geslo</label>
                                <input type="password" name = "password" class="form-control" id="login-password" placeholder="geslo"
                                value = "<?php if(isset($_COOKIE["password"])){echo $_COOKIE["password"];} ?>">
                              </div>
                              <div class="form-check">
                                <input type="checkbox" name = "remember-me" class="form-check-input" id="remember-me-input"
                                <?php if(isset($_COOKIE["email"])){ ?> checked <?php } ?>>
                                <label class="form-check-label" for="remember-me-input">Ostani prijavljen</label>
                              </div>
                              <button type="submit" class="btn btn-primary" style="margin-top: 0.8em">Prijavi se</button>
                            </form>
                        </div>

                    </div>
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