<?php

if (
    isset($_POST['usernameSignUp']) &&
    isset($_POST['passwordSignUp']) &&
    isset($_POST['passwordRetypeSignUp']) &&
    isset($_POST['displayNameSignup']) &&
    isset($_POST['emailSignUp'])
) {
    if (
        !empty($_POST['usernameSignUp']) &&
        !empty($_POST['passwordSignUp']) &&
        !empty($_POST['passwordRetypeSignUp']) &&
        !empty($_POST['displayNameSignup']) &&
        !empty($_POST['emailSignUp'])
    ) {
        $usernameEntre = $_POST['usernameSignUp'];
        $passwordEntre = $_POST['passwordSignUp'];
        $passwordRetypeEntre = $_POST['passwordRetypeSignUp'];
        $displayNameEntre = $_POST['displayNameSignup'];
        $emailEntre = $_POST['emailSignUp'];

        if ($passwordEntre == $passwordRetypeEntre) {
            require_once dirname(__FILE__) . '/../access/db.php';

            //checker si le username est libre
            $usernameEntreFiltre = mysqli_real_escape_string(
                $maConnection,
                $usernameEntre
            );

            $maRequetePourCheckerSiLeUsernameEstLibre = "SELECT username FROM users WHERE username = '$usernameEntreFiltre'";
            $retourRequeteCheckUsername = mysqli_query(
                $maConnection,
                $maRequetePourCheckerSiLeUsernameEstLibre
            );

            if ($retourRequeteCheckUsername->num_rows == 0) {
                $passwordEntreCrypte = md5($passwordEntre);
                require_once dirname(__FILE__) . '/../access/salt.php';
                $passwordEntreCrypteSaleCrypte =
                    $passwordEntreCrypte . md5($salt);

                $maRequeteInscription = "INSERT INTO users (username, password,display_name,email,images) VALUES ('$usernameEntre', '$passwordEntreCrypteSaleCrypte','$displayNameEntre','$emailEntre', 'default2.jpeg')";
                $resultatInscription = mysqli_query(
                    $maConnection,
                    $maRequeteInscription
                );

                if ($resultatInscription) {
                    header('location: index.php?info=registered');
                } else {
                    die(mysqli_error($maConnection));
                }
            } else {
                $message = 'username non disponible';
            }
        } else {
            $message = 'les deux mots de passe ne matchent pas';
        }
    } else {
        $message = 'il manque des trucs dans le formulaire';
    }
} else {
    $message = 'il manque des trucs';
}

?>
