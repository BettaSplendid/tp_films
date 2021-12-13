<?php

require_once('config/config.php');

// Check if the user is logged in, if not then redirect him to login page
var_dump($_SESSION["logged_in"]);
var_dump($_SESSION["pseudo"]);
var_dump($_SESSION["mail"]);
var_dump($_SESSION["id"]);
var_dump($_SESSION["age"]);
var_dump($_SESSION["adult"]);


$pass_session_mail = $_SESSION["mail"];
$pass_session_pseudo = $_SESSION["pseudo"];
$pass_session_logged = $_SESSION["logged_in"];
$pass_session_id = $_SESSION["id"];
$pass_session_age = $_SESSION["age"];
$pass_session_adult = $_SESSION["adult"];
$movie_to_display = strip_tags($_GET['movie_to_show']);

if ($_SESSION["logged_in"] == true)
    echo ("Logged in");
else
    echo ("Not logged in");
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Parrot Movies Assistant</title>
    <meta property="og:image" content="https://thumbs.dreamstime.com/z/parrot-sits-branch-bright-silhouette-drawn-various-lines-style-minimalism-tattoo-bird-logo-parrot-sits-174762319.jpg">
    <meta property="og:title" content="Parrot Homework Network">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="icon" href="assets/better_parrot.ico" type="image/x-icon">
    <link rel="shortcut icon" href="assets/better_parrot.ico" type="image/x-icon">
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
        <a href="categories.php">Categories</a>
        <a href="popular.php">popular</a>
        <a class="active" href="index.php">Accueil</a>
    </div>
    <div class="super_container">
        <!-- SHHHHH -->
        <div class="special_secret_div">
            <input type="text" name="name" id="pass_session_mail" style="display: none;" value=<?= $pass_session_mail ?>>
            <input type="text" name="name" id="pass_session_pseudo" style="display: none;" value=<?= $pass_session_pseudo ?>>
            <input type="text" name="name" id="pass_session_logged" style="display: none;" value=<?= $pass_session_logged ?>>
            <input type="text" name="name" id="pass_session_id" style="display: none;" value=<?= $pass_session_id ?>>
            <input type="text" name="name" id="pass_session_age" style="display: none;" value=<?= $pass_session_age ?>>
            <input type="text" name="name" id="pass_session_adult" style="display: none;" value=<?= $pass_session_adult ?>>

            <input type="text" name="name" id="movie_to_display" style="display: none;" value=<?= $movie_to_display ?>>
        </div>
        <div class="the_cool_movies">
            A la une :
            <div class="movie_info"></div>

        </div>
    </div>
</body>
<script type="text/javascript" src="GetMovieInfo.js">
</script>

</html>