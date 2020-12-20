<!DOCTYPE html>
<html>

<?php

include("includes.php");

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Oops!</title>
    <meta name="author" content="name">
    <meta name="description" content="Seems like we're having some issues">
    <meta name="keywords" content="keywords,here">
    <link rel="stylesheet" href="https://cubey.cc/error.css" type="text/css">
</head>

<body style="height: 100vh">
    <div class="panelcont" style="flex-direction: column; text-align: center;">
        <div class="main">
            <i class="error fas fa-exclamation-triangle"></i>
            <h1>Uh oh, something's gone wrong.</h1>
            <h3 style="padding-bottom: 20px;">
                <?php
        if(isset($_GET["error"])){
            echo $_GET["error"];
        }else{
            echo "This could usually happen when the website is under maintenance, or an error has occured.";
        }
        ?>
                <br><input class="try" type="button" value="Try Again" onclick="location.reload(); " />
            </h3>
        </div>
        <div class="info">
            <p class="einfo"><?php
            date_default_timezone_set('UTC');
        echo "Timestamp: " . date('m/d/Y H:m:s', time()) . " " . date_default_timezone_get() . "<br>";
        echo "Requested URL: ";
        if(isset($_GET["requrl"]))
        {
            echo $_GET["requrl"] . "<br>";
        }
        else{
            echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" . "<br>";
        };
        echo "Your IP: " .  $_SERVER['REMOTE_ADDR'];

?>
            </p>
        </div>
    </div>


</body>

</html>