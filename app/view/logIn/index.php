<?php
    if(isset($_SESSION["user"])){
        header("Location: ../../public/home");
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
    <link rel="stylesheet" href="../../app/res/css/main.css">

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
                <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span> List of algorithms</a></li>
                <li><a href="../../public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <h3>LINKS</h3>
            <p><a href="http://www.limfom-levkemija.org/domov.html" target="_blank">L&L</a></p>
            <p><a href="http://lrss.fri.uni-lj.si/bio/" target="_blank">Computational Biology Group</a></p>
        </div>
        <div class="col-sm-8 text-left">
            <div>
                <article>
                    <div align = "center">
                        <div style = "width:300px; margin-top: 0.8em" align = "left">
                            <form class="well" action = "<?= "logIn/loginUser/" ?>" method = "post" content="">
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
                <img src="../../app/res/photos/UL.png" class="img-responsive">
            </div>
            <div class="well">
                <img src="../../app/res/photos/SVN.png" class="img-responsive">
            </div>
            <div class="well">
                <img src="../../app/res/photos/MIZS_AN.png" class="img-responsive">
            </div>
            <div class="well">
                <img src="../../app/res/photos/esc_an.jpg" class="img-responsive">
            </div>
        </div>
    </div>
</div>

<!-- <footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer> -->