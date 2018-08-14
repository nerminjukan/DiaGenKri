<?php
require_once '../app/database/DBfunctions.php';
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
                <li><a href="../../../DiaGenKri/public/visualisation"><span class="glyphicon glyphicon-th"></span> List of algorithms</a></li>
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
            <div class="container-fluid row-increased-top well">
                <?php if(isset($_GET["email"]) && isset($_GET["hash"])): ?>
                    <?php
                        $_GET["email"] = htmlspecialchars($_GET["email"]);
                        $_GET["hash"] = htmlspecialchars($_GET["hash"]);
                        $res = DBfunctions::confirmActivation($_GET["email"], $_GET["hash"]);
                        if($res){
                            echo "<p>Thank you form confirming your registration, please log into the application at the log in page!</p>";
                        }
                        else{
                            echo "<p>Something went wrong, please contact our user support for help. We apologise for the inconvenience!</p>";
                        }
                    ?>

                <?php else: ?>
                <p>
                    A verification e-mail has ben sent to your e-mail address, please follow the instructions provided to confirm your registration.
                </p>
                <div class="form-group">
                    <p>
                        If the email has not arrived after 5 minutes from completing the registration process, please enter your email below and try again.
                        <br>Thank you for your patience!
                    </p>
                    <form action = "<?= "register/resend/" ?>" method = "post">
                        <div class="form-group">
                            <label for="email-resend">E-mail:</label>
                            <input type = "email" class="form-control" id="email-resend" name = "email-resend"/>
                        </div>
                        <button class="btn btn-default row-increased-bottom" type="submit" value ="Oddaj">Submit</button>
                    </form>
                </div>
                <?php endif; ?>
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