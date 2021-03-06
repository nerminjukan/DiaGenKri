<?php
require_once '../app/database/DBfunctions.php';
if(isset($_SESSION["user"])){
    header("Location: ../../public/home");
}
// include language array
if(file_exists('../app/language/lang/lang_' . $_SESSION["lang"] . '.php'))
    require_once '../app/language/lang/lang_' . $_SESSION["lang"] . '.php';
else
    require_once '../app/language/lang/lang_en.php';
?>

<!DOCTYPE html>
<html lang="<?php echo $lang["lang"]?>">
<head>
    <title>Register</title>
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
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-sign-language"></i> <?php echo $_SESSION["lang"]; ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php
                        foreach ($_SESSION["available_languages"] as $key => $value) {
                            if ($value == $_SESSION["lang"])
                                continue;
                            echo "<li><a href=../../public/register/confirm?lang=$value>$value</a></li>";
                        }
                        ?>
                    </ul>
                </li>
                <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span><?php echo $lang["algorithm_list"]; ?></a></li>
                <li><a href="../../public/logIn"><span class="glyphicon glyphicon-user"></span> <?php echo $lang["user_log_in"]; ?></a></li>
            </ul>
        </div>
    </div>

</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <div class="col-sm-2 sidenav">
            <h3><?php echo $lang["links_page"]; ?></h3>
            <p><a href="http://www.limfom-levkemija.org/domov.html" target="_blank"><img class="image img-responsive img-thumbnail" src="../../app/res/photos/logo_LL.png"></a></p>
            <p><a href="http://lrss.fri.uni-lj.si/bio/" target="_blank"><img class="image img-responsive img-thumbnail" src="../../app/res/photos/BG-logo.PNG"></a></p>
        </div>
        <div class="col-sm-8 text-left">
            <div class="container-fluid row-increased-top well">
                <?php if(isset($_GET["email"]) && isset($_GET["hash"])): ?>
                    <?php
                        $_GET["email"] = htmlspecialchars($_GET["email"]);
                        $_GET["hash"] = htmlspecialchars($_GET["hash"]);
                        $res = DBfunctions::confirmActivation($_GET["email"], $_GET["hash"]);
                        if($res){
                            echo "<p>".$lang['confirm_registration-OK']."</p>";
                        }
                        else{
                            echo "<p>".$lang['confirm_registration-NOK']."</p>";
                        }
                    ?>

                <?php else: ?>
                <p>
                    <?php echo  $lang['confirm_mail-sent']; ?>
                </p>
                <div class="form-group">
                    <p>
                        <?php echo  $lang['confirm_mail-resend']; ?>
                    </p>
                    <form action = "<?= "resend" ?>" method = "post">
                        <div class="form-group">
                            <label for="email-resend"><?php echo  $lang['confirm_enter-mail']; ?></label>
                            <input type = "email" class="form-control" id="email-resend" name = "email-resend"/>
                        </div>
                        <button class="btn btn-default row-increased-bottom" type="submit" value ="Oddaj"><?php echo $lang['submit-btn']; ?></button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <?php
            try{
                if(isset($_SESSION["errors"])){
                    foreach ($_SESSION["errors"] as $key => $value){

                        echo "<span style=\"color: red\" id=\"errors\">$value</span><br>";
                    }
                    $_SESSION["errors"] = null;
                }
            } catch (Exception $e){

            }
            ?>
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