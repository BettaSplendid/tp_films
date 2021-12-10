<?php
require_once('config/config.php');

$register_or_login = strip_tags($_POST['submit-type']);
login_or_register_referral($dtbs);

function login_or_register_referral($dtbs)
{
    global $register_or_login;
    var_dump($register_or_login);
    echo ("<br>");
    if ($register_or_login == "Register!") {
        da_register_process_controller($dtbs);
    } else if ($register_or_login == "Login!") {
        da_login_process_controller($dtbs);
    } else {
        echo ("Can't tell if register or login");
        return;
    }
}

function da_register_process_controller($dtbs)
{
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

    $user_data_array = array(
        'user_data_name' => $name,
        'user_data_mail' => $mail,
        'user_data_password' => $password,
        'user_data_password_repeated' => $password_repeated,
        'user_data_user_age' => $user_age
    );

    echo  nl2br(" \n");
    echo  nl2br(" \n");
    echo "name : $name";
    echo  nl2br(" \n");
    echo "mail : $mail";
    echo nl2br(" \n");
    echo "password : $password";
    echo  nl2br(" \n");
    echo "age : $user_age";
    echo  nl2br(" \n");
    echo "password repeat : $password_repeated";
    echo  nl2br(" \n");
    echo  nl2br(" \n");

    echo ("register process controller <br>");

    if (variables_presence_verification($user_data_array)) {
        echo ("a<br>");
        return;
    } else if (variables_content_verification($user_data_array)) {
        echo ("a1<br>");
        return;
    } else if (mail_validity_ver($user_data_array["user_data_mail"])) {
        echo ("b<br>");
        return;
    } else if (mdp_input_compare($user_data_array["user_data_password"], $user_data_array["user_data_password_repeated"])) {
        echo ("c<br>");
        return;
    }

    // $_SESSION["id"] = get_user_id($mail, $dtbs);

    if (check_and_insert($user_data_array, $dtbs)) {
        echo ("d<br>");
        return;
    } else if (set_da_session_things_after_register($user_data_array, $_SESSION["id"])) {
        echo ("e<br>");
        return;
    }


    echo ("z<br>");
    echo ("<br>");
    echo ("Sessions info");
    echo ("<br>");

    echo ("session logged_in : <br />");
    var_dump($_SESSION["logged_in"]);

    echo ("session pseudo : <br />");
    var_dump($_SESSION["pseudo"]);
    echo ("session mail : <br />");
    var_dump($_SESSION["mail"]);
    echo ("session id : <br> age");
    var_dump($_SESSION["id"]);
    echo ("session age : <br>");
    var_dump($_SESSION["age"]);
    echo ("fin <br>");

    redirect_welcome_page_results();
}

function da_login_process_controller($dtbs)
{
    echo ("login process controller <br>");

    $mail = normal_chars(strip_tags($_POST['email']));
    $password = normal_chars(strip_tags($_POST['password']));

    var_dump($mail);
    echo ("<br>");
    var_dump($password);
    echo ("<br>");

    $login_process = checkvariables($mail, $password);
    if ($login_process == 1) {
        echo ("login error <br>");
        return;
    }
    echo ("login step <br>");

    $login_process = check_variables_content($mail, $password);
    if ($login_process == 1) {
        echo ("login error1 <br>");
        return;
    }

    $login_process = check_db_login($mail, $password, $dtbs);
    if ($login_process == 1) {
        echo ("login error2 <br>");
        return;
    }

    set_da_session_things_after_login($mail, $dtbs);
    redirect_welcome_page_results();
}



function normal_chars($string)
{
    $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    $string = preg_replace('~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', $string);
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');


    return trim($string, ' -');
}


function variables_presence_verification($user_data_array)
{
    if ((!isset($user_data_array['user_data_name'])) || (!isset($user_data_array['user_data_mail'])) || (!isset($user_data_array['user_data_password']))  || (!isset($user_data_array['user_data_password_repeated'])) || (!isset($user_data_array['user_data_user_age']))) {
        echo ('Il vous faut un name, mail, mdp et une verification correcte pour vous inscrire. Bouuh. Sale nul. <br>');
        return 1;
    }
    echo ("les variables sont presentes <br>");
}

function variables_content_verification($user_data_array)
{

    if (empty($user_data_array['user_data_name']) || empty($user_data_array['user_data_mail']) || empty($user_data_array['user_data_password']) || empty($user_data_array['user_data_password_repeated']) || empty($user_data_array['user_data_user_age'])) {
        echo ("Une variable importante vaut soit 0, vide, ou pas définie du tout <br>");
        return 1;
    }
    echo ("les variables sont remplies <br>");
}


// Verifier validité du mail
function mail_validity_ver($mail)
{
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo ("$mail is a valid email address <br>");
        return 0;
    } else {
        echo ("$mail is not a valid email address <br>");
        return 1;
    }
}


function checkvariables($mail, $password)
{
    if (!isset($mail) || !isset($password)) {
        echo ('Il vous faut un name, mail, mdp et une verification correcte pour vous inscrire. Bouuh. Sale nul. <br>');
        return 1;
    }
    echo ("variables definies <br>");
    return 0;
}

function check_variables_content($mail, $password)
{
    if (empty($mail) || empty($password)) {
        echo ("Une variable importante vaut soit 0, vide, ou pas définie du tout <br>");
        echo  nl2br(" \n");
        return 1;
    }
    echo ("variables remplies <br>");
    return 0;
}

function check_db_login($mail, $password, $dtbs)
{
    $search_request = 'SELECT * FROM `tp_users` WHERE email = :mail';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["mail" => $mail]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array

    var_dump($resultat_array);

    if (empty($resultat_array)) {
        echo ("<br>no matching account <br>");
        return 1;
    }
    echo ("<br>matching account <br>");
    $le_resultat = $resultat_array[0]["password"];

    if ($le_resultat == $password) {
        echo ("<br>Found matching password <br>");
        return 0;
    }

    // Not supposed to happen but just in case
    echo "<br>Error during database handshake. test failed. <br>";
    return 1;
}

function set_da_session_things_after_login($mail, $dtbs)
{

    echo ("<br> Setting session variables login");

    var_dump($dtbs);

    $search_request = 'SELECT * FROM `tp_users` WHERE email = :mail';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["mail" => $mail]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array

    $_SESSION['logged_in'] = true;
    $_SESSION['mail'] = $mail;
    $_SESSION['pseudo'] = $resultat_array[0]["name"];;
    $_SESSION['age'] = $resultat_array[0]["age"];
    $_SESSION['id'] = $resultat_array[0]["id"];
    $_SESSION['adult'] = $resultat_array[0]["adult"];

    echo ("<br> session logged_in : <br />");
    var_dump($_SESSION["logged_in"]);
    echo ("<br> session pseudo : <br />");
    var_dump($_SESSION["pseudo"]);
    echo ("<br> session mail : <br />");
    var_dump($_SESSION["mail"]);
    echo ("<br> session id : <br> age");
    var_dump($_SESSION["id"]);
    echo ("<br> session age : <br>");
    var_dump($_SESSION["age"]);
    echo ("<br> session adult : <br>");
    var_dump($_SESSION["adult"]);
    echo ("<br> fin <br>");
}




// Compare les MDP
function mdp_input_compare($password, $password_repeated)
{
    if (strcmp($password, $password_repeated) !== 0) {
        echo "Vos mots de passe ne sont pas identiques. Veuillez les verifier. <br>";
        return 1;
    } else {
        echo "Mdp identiques. Bien.<br>";
        return 0;
    }
}


function ze_inserto($name, $mail, $password, $age, $dtbs)
{

    if ($age < 18) {
        $adult = 0;
    } else {
        $adult = 1;
    }

    // INSERT USERS AFTER VERIFICATION CHECK
    $insert_request = 'INSERT INTO tp_users(name, email, password, age, adult) VALUES (:name, :mail, :password, :age, :adult)';

    // Prepare
    $insertusers = $dtbs->prepare($insert_request);

    // Exécution !
    $insertusers->execute([
        'name' => $name,
        'mail' => $mail,
        'password' => $password,
        'age' => $age,
        'adult' => $adult,
    ]);

    echo "Insertion reussi.";
    echo  nl2br(" \n");
}




function search_db_name($name, $dtbs)
{

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

function search_db_mail($mail, $dtbs)
{

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
function check_and_insert($user_data_array, $dtbs)
{
    echo "Search da db <br />";
    if (search_db_name($user_data_array["user_data_name"], $dtbs)) {
        echo "Found duplicate xdata, no insertion<br />";
        return 1;
    } elseif (search_db_mail($user_data_array["user_data_mail"], $dtbs)) {
        echo "Found duplicate data, no insertion<br />";
        return 1;
    } else {
        echo "Attempting to insert da data <br />";
        ze_inserto($user_data_array["user_data_name"], $user_data_array["user_data_mail"], $user_data_array["user_data_password"], $user_data_array["user_data_user_age"], $dtbs);
        return 0;
    }
}

function get_user_id($mail, $dtbs)
{

    $search_request = 'SELECT * FROM `tp_users` WHERE email = :email';
    $prepare__search = $dtbs->prepare($search_request);
    $prepare__search->execute(["email" => $mail]); // run the statement
    $resultat_array = $prepare__search->fetchAll(PDO::FETCH_ASSOC); // fetch the rows and put into associative array  

    $da_result = $resultat_array[0]['id'];
    echo ("user id here : $da_result <br>");
    return $da_result;
}

function set_da_session_things_after_register($user_data_array, $user_id)
{
    $_SESSION['logged_in'] = true;
    $_SESSION['mail'] = $user_data_array["user_data_mail"];
    $_SESSION['pseudo'] = $user_data_array["user_data_name"];
    $_SESSION['age'] = $user_data_array["user_data_user_age"];
    $_SESSION['id'] = $user_id;

    echo ("setting session variables <br>");
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
        header("location: index.php");
        echo ("<br>You are going to index.php<br>");
        exit;
    } else {
        header("location: accounts.php");
        echo ("<br>You are going to accounts.php<br>");
        exit;
    }
}
