<?php

require_once('config/config.php');

// // Check if the user is already logged in, if yes then redirect him to welcome page
// if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
//     header("location: welcome.php");
//     exit;
// }

var_dump($_SESSION['logged_in']);

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
        <a href="popular.php">Popular</a>
        <a class="active" href="index.php">Accueil</a>
    </div>
    <div class="super_container">



        <div class="reception_container">
            <div class="entry_form_container">

                <div class="form-status"></div>
                <form action="process.php" method="POST" class="form-register">
                    <div>
                        <input type="text" name="name" id="name" placeholder="Your name *">
                    </div>

                    <div>
                        <input type="email" name="email" id="email" placeholder="Your email *">
                    </div>

                    <div>
                        <input type="number" name="age" id="age" placeholder="Your age *">
                    </div>

                    <div>
                        <input type="password" name="password" id="password" placeholder="Password *" />
                    </div>

                    <div>
                        <input type="password" name="password-repeat" id="password-repeat" placeholder="Confirm Password *" />
                    </div>

                    <p>En creant un compte, vous acceptez nos <a href="https://cultofthepartyparrot.com">conditions d'utilisations</a>.</p>

                    <div>
                        <input type="submit" value="Register!" name="submit-type" id="submit-type">
                    </div>

                </form>

                <form action="process.php" method="POST" class="form-login">
                    <div>
                        <input type="email" name="email" id="email" placeholder="Your email *">
                    </div>
                    <div>
                        <input type="password" name=password id="password" placeholder="Password *" />
                        <div>
                            <input type="submit" value="Login!" name="submit-type" id="submit-type">
                        </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>