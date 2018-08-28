<!DOCTYPE html>
<html lang="sl">
<head>
    <title>Home</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../app/res/css/main.css">
    <script src="../../app/res/js/curations.js"></script>


</head>


<!-- <div class="box"> -->

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

                    <?php if(isset($_SESSION["user"]) && $_SESSION["user-admin"] == 1 || isset($_SESSION["user-add"]) && $_SESSION["user-add"] == 1): ?>
                <li><a href="../../public/visualisation/editor"><span class="glyphicon glyphicon-pencil">
                    </span> Create algorithm</a></li>
                <?php endif; ?>


                    <?php if(isset($_SESSION["user"]) && $_SESSION["user-confirm"] == 1): ?>
                        <li><a href="../../public/visualisation/curations">
                                <span class="label label-pill label-danger count"></span> <span class="glyphicon glyphicon-bell" ></span> Curation requests</a></li>
                    <?php endif; ?>

                            <li><a href="../../public/visualisation"><span class="glyphicon glyphicon-th"></span> List of algorithms</a></li>

                    <?php if(isset($_SESSION["user"])): ?>

                        <?php if(isset($_SESSION["user-admin"]) && $_SESSION["user-admin"] == 1): ?>
                            <li><a href="../../public/administrate"><span class="glyphicon glyphicon-cog"></span> Administrate</a></li>
                        <?php endif; ?>

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

                                        <div class="col-lg-4 image">
                                            <p class="text-center">
                                                <?php
                                                $userMail = $_SESSION["user"];
                                                if(file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpg")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".jpg";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".JPG";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".png")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".png";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".PNG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".PNG";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".jpeg")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".jpeg";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                elseif (file_exists("../app/res/photos/profilePhotos/" . $userMail . ".JPEG")){
                                                    $picture = "../app/res/photos/profilePhotos/" . $userMail . ".JPEG";
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=$picture style=\"max-width: 90%\">";
                                                }
                                                else{
                                                    echo "<img class=\"row-increased-top img-responsive img-thumbnail\" src=\"../../app/res/photos/avatar.jpg\" style=\"max-width: 50%\">";
                                                }
                                                ?>
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
                                                <a href="../../public/profile" class="btn btn-primary btn-block btn-sm">My profile</a>
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

                                                <a href="../../public/logIn/logOutUser/" class="btn btn-danger btn-block">Log out</a>

                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <?php else: ?>

                    <li><a href="../../public/register"><span class="glyphicon glyphicon-log-in"></span> Registration</a></li>
                    <li><a href="../../public/logIn"><span class="glyphicon glyphicon-user"></span> Log in</a></li>

                    <?php endif; ?>
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
                <h1>Welcome</h1>
                <p>This website is dedicated to visualising algorithms for genetic disease diagnosis.</p>
                <hr>
                <h3>What would you like to do?</h3>
                <?php if(isset($_SESSION["user"])):?>
                <div class="container col-sm-4 row-increased-top">
                    <a href="../../public/visualisation/editor" title=""><img src="../../app/res/photos/graph-example.jpg" class="image img-responsive img-thumbnail"></a>
                    <div class="middle">
                        <div class="text"><a class="a-tag" href="../../public/visualisation/editor" title="">Create algorithm</a></div>
                    </div>
                </div>
                <?php endif;?>
                <div class="container col-sm-4 row-increased-top">
                    <a href="../../public/visualisation/diagnosis" title=""><img src="../../app/res/photos/disease-modal.jpg" class="image img-responsive img-thumbnail"></a>
                    <div class="middle">
                        <div class="text"><a class="a-tag" href="../../public/visualisation/diagnosis" title="">Diagnose yourself</a></div>
                    </div>
                </div>
                <div class="container col-sm-4 row-increased-top">
                    <a href="../../public/home/about" title=""><img src="../../app/res/photos/list.JPG" class="image img-responsive img-thumbnail"></a>
                    <div class="middle">
                        <div class="text"><a class="a-tag" href="../../public/visualisation" title="">List of algorithms</a></div>
                    </div>
                </div>
                <div class="container col-sm-4 row-increased-top">
                    <a href="../../public/home/about" title=""><img src="../../app/res/photos/ViDis-logo.jpg" class="image img-responsive img-thumbnail"></a>
                    <div class="middle">
                        <div class="text"><a class="a-tag" href="../../public/home/about" title="">About ViDis</a></div>
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

    <footer class="col-sm-12 container-fluid text-center">
        <p>©DiaGenKri</p>
    </footer>

<!-- </div> -->

