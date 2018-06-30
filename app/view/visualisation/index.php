<?php

if(!isset($_SESSION["user"])){
    header("Location: ../../../DiaGenKri/public/home");
}


require_once '../app/database/DBfunctions.php';
include_once '../app/controllers/administrate.php';

$data = DBfunctions::getGraphs();

?>

<!DOCTYPE html>
<html lang="sl">

<head>
    <title>Graphs table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../../DiaGenKri/app/res/css/main.css">
    <script src="../../../DiaGenKri/app/res/js/filter.js"></script>

</head>


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
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="well well-sm col-sm-12">
    <h3 style="margin-top: 10px">Filters:</h3>
    <form name="gForm" role="form" class="form-inline">
        <div class="well well-sm form-group">
            <div class="form-group">
                <label for="gName">Graph name:</label>
                <input onkeyup="filterTable()" type="email" class="form-control" id="gName" placeholder="enter graph name">
            </div>
            <div>
                <button type="button" onclick="resetFilters()" class="btn btn-sm btn-warning">Clear filters</button>
            </div>
        </div>
        <div class="well well-sm form-group">
            <label class="col-sm-6 control-label"
                    >Graph type:</label>
            <div class="col-sm-6">
                <div>
                    <label class="radio-inline" for="typeDAll"><input onchange="filterTable()" checked class="radio" type="radio" id="typeDAll" name="gType" value="all">All</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeVisual"><input onchange="filterTable()" class="radio" id="typeVisual" type="radio" name="gType" value="visual">Visual</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeDiagnostic"><input onchange="filterTable()" class="radio" type="radio" id="typeDiagnostic" name="gType" value="diagnostic">Diagnostic</label>
                </div>
                <label style="color: red; font-size: 14px" id="typeLab"></label>
            </div>
        </div>
        <div class="well well-sm form-group">
            <label class="col-sm-6 control-label"
                    >Algorithm type:</label>
            <div class="col-sm-6">
                <div>
                    <label class="radio-inline" for="typeADiagnostic"><input onchange="filterTable()" class="radio" type="checkbox" id="typeADiagnostic" name="aType" value="1">Diagnostic</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeATreatment"><input onchange="filterTable()" class="radio" id="typeATreatment" type="checkbox" name="aType" value="2">Treatment</label>
                </div>
                <div>
                    <label class="radio-inline" for="typeAOther"><input onchange="filterTable()" class="radio" type="checkbox" id="typeAOther" name="aType" value="4">Other</label>
                </div>
                <label style="color: red; font-size: 14px" id="typeLab"></label>
            </div>
        </div>
    </form>

    <div>
        <a class="btn btn-success" href="../../../DiaGenKri/public/visualisation/editor">New graph</a>
    </div>
</div>


<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-12 text-left">
            <table id="graphTable" class="table table-sc table-hover table-responsive table-striped">
                <thead>
                <tr class="tr-sc" style="text-align: center">
                    <th>ID</th>
                    <th>Author</th>
                    <th>Graph name</th>
                    <th>Graph type</th>
                    <th>Algorithm type</th>
                    <th>Created</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody class="tbody-sc">
                <?php foreach ($data as $key => $value){
                    $id = $value["id"];
                    $email = $value["e-mail"];
                    $name = $value["name"];
                    $visual = $value["visual"];

                    if($visual === '0'){
                        $visual = 'Diagnostic';
                    }
                    else{
                        $visual = 'Visual';
                    }

                    $algorithmType = $value["algorithm_type"];

                    if($algorithmType === '0') {
                        $algorithmType = '-';
                    }
                    else if($algorithmType === '1'){
                        $algorithmType = 'Diagnostic';
                    }
                    else if($algorithmType === '2'){
                        $algorithmType = 'Treatment';
                    }
                    else if($algorithmType === '3'){
                        $algorithmType = 'Diagnostic, treatment';
                    }
                    else if($algorithmType === '4'){
                        $algorithmType = 'Other';
                    }
                    else if($algorithmType === '5'){
                        $algorithmType = 'Diagnostic, other';
                    }
                    else if($algorithmType === '6'){
                        $algorithmType = 'Treatment, other';
                    }
                    else if($algorithmType === '7'){
                        $algorithmType = 'Diagnostic, treatment, other';
                    }


                    $created = $value["created"];
                    $button = "<form action=\"visualisation/edit\" method=\"get\">
                                <input hidden type=\"text\" value='$id' name=\"id\"><br>
                                <input class='btn btn-block btn-primary' value='Edit' type=\"submit\">
                                </form>";

                    echo "<tr class='tr-sc'><td style=\"white-space: nowrap; width: 6%\">$id</td><td style=\"white-space: nowrap; width: 12%\">$email</td><td style=\"white-space: nowrap; width: 19%\">$name</td><td style=\"white-space: nowrap; width: 16%\">$visual</td><td style=\"white-space: nowrap; width: 21%\">$algorithmType</td><td style=\"white-space: nowrap; width: 12.5%\">$created</td><td style=\"white-space: nowrap; width: 10.2%\">$button</td></tr>";

                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="container-fluid text-center">
    <p>©DiaGenKri</p>
</footer>