<?php
    // determine langauge, english by default
    // set cookie and read language from cookie
    if (!isset($_SESSION["lang"])) {
        if (isset($_COOKIE["lang"]))
            $_SESSION["lang"] = $_COOKIE["lang"];
        else     
            $_SESSION["lang"] = "en";
    } else if (isset($_GET["lang"]) && $_SESSION["lang"] != $_GET["lang"] && !empty($_GET["lang"])) {
        $_SESSION["lang"] = $_GET["lang"];
        // set cookie for one year
        setcookie("lang", $_SESSION["lang"], time() + (3600 * 24 * 365));
    }
    //var_dump("Lang: " . $_SESSION["lang"]);
?>