<?php
require_once('config/config.php');

$register_or_login = strip_tags($_POST['submit-type']);

login_or_register_referral();

function login_or_register_referral()
{
    global $register_or_login;
    var_dump($register_or_login);
    if ($register_or_login == "Register!") {
        da_register_process_controller();
    } else if ($register_or_login == "Login!") {
        da_login_process_controller();
    } else {
        echo ("Can't tell if register or login");
        return;
    }
}

$name = strip_tags($_POST['name']);
$mail = strip_tags($_POST['email']);
$password = strip_tags($_POST['password']);
$password_repeated = strip_tags($_POST['password-repeat']);
$user_age = strip_tags($_POST['age']);


function da_register_process_controller()
{
    first_variables_cleanup(1);

    echo ("register process controller <br>");

    if (variables_presence_verification()) {
        echo ("a");
        // return;
    } else if (variables_content_verification()) {
        echo ("a1");
        // return;
    } else if (mail_validity_ver()) {
        echo ("b");
        return;
    } else if (mdp_input_compare()) {
        echo ("c");
        return;
    } else if (check_and_insert()) {
        echo ("d");
        return;
    } else if (set_da_session_things_after_login()) {
        echo ("e");
        return;
    }

    echo ("z");
    set_da_session_things_after_login();
    redirect_welcome_page_results();

    echo ("<br>");
    echo ("var_dumps");
    var_dump($_SESSION["logged_in"]);
    echo ("<br />");
    var_dump($_SESSION["pseudo"]);
    echo ("<br />");
    var_dump($_SESSION["mail"]);
    echo ("<br />");
    var_dump($_SESSION["id"]);
    echo ("<br> age");
    var_dump($_SESSION["age"]);
    echo ("<br> fin");
}

function da_login_process_controller()
{
    first_variables_cleanup(0);

    echo ("login process controller <br>");

    if (variables_presence_verification()) {
        echo ("a");
        return;
    } else if (variables_content_verification()) {
        echo ("a1");
        return;
    } else if (mail_validity_ver()) {
        echo ("b");
        return;
    } else if (mdp_input_compare()) {
        echo ("c");
        return;
    }
}

function normal_chars($string)
{
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');


    return trim($string, ' -');
}

function first_variables_cleanup($boolean)
{
    $rgster = $boolean;
    // 1 = register / 0 = login
    if ($rgster) {
        $name = strip_tags($_POST['name']);
        $mail = strip_tags($_POST['email']);
        $password = strip_tags($_POST['password']);
        $password_repeated = strip_tags($_POST['password-repeat']);
        $user_age = strip_tags($_POST['age']);

        $name = normal_chars($name);
        $mail = normal_chars($mail);
        $password = normal_chars($password);
        $password_repeated = normal_chars($password_repeated);
        $user_age = normal_chars($user_age);

        echo  nl2br(" \n");
        echo  nl2br(" \n");
        echo "mail : $mail";
        echo nl2br(" \n");
        echo "name : $name";
        echo  nl2br(" \n");
        echo "password : $password";
        echo  nl2br(" \n");
        echo "age : $user_age";
        echo  nl2br(" \n");
        echo "password repeat : $password_repeated";
        echo  nl2br(" \n");
        echo  nl2br(" \n");
    } else {
        echo nl2br(" \n");
    }
}



function variables_presence_verification()
{
    // Verification de la variable
    global $name;
    global $mail;
    global $password;
    global $password_repeated;
    global $user_age;

    var_dump($name);
    var_dump($mail);
    var_dump($password);
    var_dump($password_repeated);
    var_dump($user_age);

    if ((!isset($mail)) || (!isset($name)) || (!isset($password))  || (!isset($password_repeated)) || (!isset($user_age))) {
        echo ('Il vous faut un mail, name, mdp et une verification correcte pour vous inscrire. Bouuh. Sale nul.');
        return 1;
    }
}

function variables_content_verification()
{
    global $name;
    global $mail;
    global $password;
    global $password_repeated;
    global $user_age;

    if (empty($mail) || empty($name) || empty($password) || empty($password_repeated) || empty($user_age)) {
        echo ("Une variable importante vaut soit 0, vide, ou pas définie du tout");
        echo  nl2br(" \n");
        return 1;
    }
}


// Verifier validité du mail
function mail_validity_ver()
{
    global $mail;
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo ("$mail is a valid email address");
        echo  nl2br(" \n");
        echo  nl2br(" \n");
        return 0;
    } else {
        echo ("$mail is not a valid email address");
        echo  nl2br(" \n");
        return 1;
    }
}





// Compare les MDP
function mdp_input_compare()
{
    global $password;
    global $password_repeated;
    if (strcmp($password, $password_repeated) !== 0) {
        echo "Vos mots de passe ne sont pas identiques. Veuillez les verifier.";
        echo  nl2br(" \n");
        return 1;
    } else {
        echo "Mdp identiques. Bien.";
        echo  nl2br(" \n");
        return 0;
    }
}



// VERIFIER SI IL N'y A PAS DEJA DES UTILISATEURS AVEC name OU EMAIL

function ze_inserto()
{
    global $name;
    global $mail;
    global $password;
    global $dtbs;
    // INSERT USERS AFTER VERIFICATION CHECK
    $insert_request = 'INSERT INTO tp_users(name, email, password) VALUES (:name, :mail, :password)';

    // Prepare
    $insertusers = $dtbs->prepare($insert_request);


    // Exécution !
    $insertusers->execute([
        'name' => $name,
        'mail' => $mail,
        'password' => $password,
    ]);

    echo "Insertion reussi.";
    echo  nl2br(" \n");
}




function search_db_name()
{
    global $dtbs;
    global $name;

    $search_request = 'SELECT * FROM `tp_users` WHERE name = :name';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["name" => $name]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array

    if ($resultat_array) {
        echo "duplicate name found <br />";
        return 1;
    } else {
        echo "duplicate name not found <br />";
        return 0;
    }
    // Not supposed to happen but just in case
    echo "Error, test failed. <br />";
    return 0;
}

function search_db_mail()
{
    global $dtbs;
    global $mail;

    $search_request = 'SELECT * FROM `tp_users` WHERE email = :email';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["email" => $mail]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array

    if ($resultat_array) {
        echo "duplicate mail found <br />";
        return 1;
    } else {
        echo "duplicate mail not found <br />";
        return 0;
    }
    // Not supposed to happen but just in case
    echo "Error, test failed. <br />";
    return 1;
}

// Cherche la base de donnée pour email ou name deja utilisé
// Insert les données de compte si tout est clair
function check_and_insert()
{
    echo "Search da db <br />";
    if (search_db_name()) {
        echo "Found duplicate xdata, no insertion<br />";
        return 1;
    } elseif (search_db_mail()) {
        echo "Found duplicate data, no insertion<br />";
        return 1;
    } else {
        // Insertion des données
        echo "Attempting to insert da data <br />";
        ze_inserto();
        return 0;
    }
}


function set_da_session_things_after_login()
{
    global $name;
    global $mail;
    global $user_age;
    global $dtbs;

    $search_request = 'SELECT * FROM `tp_users` WHERE name = :name';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["name" => $name]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array

    $le_name = $resultat_array[0]['name'];
    $le_id = $resultat_array[0]['id'];

    $_SESSION['id'] = $le_id;
    $_SESSION['mail'] = $mail;
    $_SESSION['pseudo'] = $name;
    $_SESSION['logged_in'] = true;
    $_SESSION["age"] = $user_age;

    var_dump($_SESSION["logged_in"]);
    echo ("<br />");
    var_dump($_SESSION["pseudo"]);
    echo ("<br />");
    var_dump($_SESSION["mail"]);
    echo ("<br />");
    var_dump($_SESSION["id"]);
    echo ("<br />");
    var_dump($_SESSION["age"]);
    echo ("<br />");
}

function redirect_welcome_page_results()
{
    // If logged in, to index
    // If failed to login, back to accounts
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        // header("location: index.php");
        echo ("You are going to index.php");
        exit;
    } else {
        // header("location: accounts.php");
        echo ("You are going to accounts.php");
        exit;
    }
}
