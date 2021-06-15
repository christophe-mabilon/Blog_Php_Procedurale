<?php

$modeInscription = false;
$isAdmin = false;
$isLoggedIn = false;
$leSecret = "non mais c'est un secret";

if (isset($_SESSION['userId'])) {
    $isLoggedIn = true;
}

if ($isLoggedIn) {
    $loggedIn = 'Tu est connecté';
} else {
    require_once 'login.php';
}
if (isset($_POST['modeInscription']) && $_POST['modeInscription'] == 'on') {
    $modeInscription = true;
    require_once 'signup.php';
}
if (isset($_POST['modeInscription']) && $_POST['modeInscription'] == 'off') {
    $modeInscription = false;
}

if ($modeInscription) {
    require_once 'signup.php';
}

?>
