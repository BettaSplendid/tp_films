<?php

require_once('config/config.php');

// Check if the user is logged in, if not then redirect him to login page
var_dump($_SESSION["logged_in"]);
var_dump($_SESSION["pseudo"]);
var_dump($_SESSION["mail"]);
var_dump($_SESSION["id"]);
var_dump($_SESSION["age"]);

if($_SESSION["logged_in"] == true)
    echo("Logged in");
else
    echo("Not logged in");
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Parrot Movies Assistant</title>
    <meta name="description" content="Description importantes">
    </meta>
    <meta property="og:image" content="https://thumbs.dreamstime.com/z/parrot-sits-branch-bright-silhouette-drawn-various-lines-style-minimalism-tattoo-bird-logo-parrot-sits-174762319.jpg">
    <meta property="og:title" content="Parrot Homework Network">

    <link rel="shortcut icon" href="assets/better parrot.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/le_css.css">
</head>

<body>
    <div class="superheader"></div>
    <div class="header_bar">
        <img class="header_logo" src='assets/sharpparrot.png'>
    </div>
    <div class="bar_bar">
        <a href="disconnect.php">Deconnection</a>
        <a href="accounts.php">Comptes</a>
        <a href="https://cultofthepartyparrot.com/">News</a>
        <a href="articles.php">Articles</a>
        <a class="active" href="index.php">Accueil</a>
    </div>
    <div class="super_container">



    </div>
</body>

</html>