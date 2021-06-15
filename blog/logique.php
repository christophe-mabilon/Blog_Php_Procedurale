<?php

session_start();
if (isset($_POST['logOut'])) {
    session_unset();
}

$racineSite = 'http://localhost/php/blog';

require_once dirname(__FILE__) . '/../authentification/auth.php';
require_once dirname(__FILE__) . '/../access/db.php';

$isOwner = false;
$isUser = false;

//verification Admin
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    $isAdmin = true;
}
// modification images post

if (isset($_POST['postPic']) && $_POST['postPic'] == 'upload') {
    if (isset($_FILES['postPictureToUpload']['name'])) {
        if ($_SESSION['userId'] == $_POST['authorId']) {
            $postId = $_POST['postId'];
            $extensionsAutorisees = ['jpeg', 'jpg', 'png', 'webp'];

            $hauteurMax = 720;
            $largeurMax = 900;

            $tailleMax = 3000000;

            $repertoireUpload = '../images/posts/';

            $nomTemporaireFichier = $_FILES['postPictureToUpload']['tmp_name'];

            $mesInfos = getimagesize(
                $_FILES['postPictureToUpload']['tmp_name']
            );

            $monTableauExtensions = explode('/', $mesInfos['mime']);
            $extensionUploadee = $monTableauExtensions[1];

            $unTableau = explode('\\', $nomTemporaireFichier);

            $nomTemporaireSansChemin = end($unTableau);

            $nomFinalDuFichier =
                $nomTemporaireSansChemin . '.' . $extensionUploadee;

            $destinationFinale = $repertoireUpload . $nomFinalDuFichier;

            $maLargeur = $mesInfos[0];
            $maHauteur = $mesInfos[1];

            $maTaille = $_FILES['postPictureToUpload']['size'];

            if (in_array($extensionUploadee, $extensionsAutorisees)) {
                if ($maTaille <= $tailleMax) {
                    if (
                        $maLargeur <= $largeurMax &&
                        $maHauteur <= $hauteurMax
                    ) {
                        if (
                            move_uploaded_file(
                                $nomTemporaireFichier,
                                $destinationFinale
                            )
                        ) {
                            $requeteUploadPhotoProfile = "UPDATE posts SET images = '$nomFinalDuFichier' WHERE id = '$postId'";
                            $resultatRequete = mysqli_query(
                                $maConnection,
                                $requeteUploadPhotoProfile
                            );
                            if ($resultatRequete) {
                                header(
                                    "Location: postUnique.php?postId=$postId&info=picUploaded"
                                );
                            } else {
                                die(mysqli_error($maConnection));
                            }
                        } else {
                            header(
                                "Location: postUnique.php?postId=$postId&info=uploadFailed"
                            );
                        }

                        //
                    } else {
                        header(
                            "Location: postUnique.php?postId=$postId&info=resolution"
                        );
                    }
                } else {
                    header(
                        "Location: postUnique.php?postId=$postId&info=oversized"
                    );
                }
            } else {
                header(
                    "Location: postUnique.php?postId=$postId&info=extension"
                );
            }
        } else {
            echo "ce n'est pas VOTRE post, bas les pattes";
        }
    }
}

// Upload images de profil

if (isset($_POST['profilePic']) && $_POST['profilePic'] == 'upload') {
    if (isset($_FILES['pictureToUpload']['name'])) {
        if ($_SESSION['userId'] == $_POST['userId']) {
            $userId = $_POST['userId'];
            $extensionsAutorisees = ['jpeg', 'jpg', 'png', 'webp'];

            $hauteurMax = 720;
            $largeurMax = 900;

            $tailleMax = 3000000;

            $repertoireUpload = '../images/profiles/';

            $nomTemporaireFichier = $_FILES['pictureToUpload']['tmp_name'];
            var_dump($nomTemporaireFichier);

            $mesInfos = getimagesize($_FILES['pictureToUpload']['tmp_name']);

            $monTableauExtensions = explode('/', $mesInfos['mime']);
            $extensionUploadee = $monTableauExtensions[1];

            $unTableau = explode('\\', $nomTemporaireFichier);

            $nomTemporaireSansChemin = end($unTableau);

            $nomFinalDuFichier =
                $nomTemporaireSansChemin . '.' . $extensionUploadee;

            $destinationFinale = $repertoireUpload . $nomFinalDuFichier;

            $maLargeur = $mesInfos[0];
            $maHauteur = $mesInfos[1];

            $maTaille = $_FILES['pictureToUpload']['size'];

            if (in_array($extensionUploadee, $extensionsAutorisees)) {
                if ($maTaille <= $tailleMax) {
                    if (
                        $maLargeur <= $largeurMax &&
                        $maHauteur <= $hauteurMax
                    ) {
                        if (
                            move_uploaded_file(
                                $nomTemporaireFichier,
                                $destinationFinale
                            )
                        ) {
                            $requeteUploadPhotoProfile = "UPDATE users SET images = '$nomFinalDuFichier' WHERE id = '$userId'";
                            $resultatRequete = mysqli_query(
                                $maConnection,
                                $requeteUploadPhotoProfile
                            );
                            if ($resultatRequete) {
                                header(
                                    "Location: profile.php?profile=$userId&info=picUploaded"
                                );
                            } else {
                                die(mysqli_error($maConnection));
                            }
                        } else {
                            header(
                                "Location: profile.php?profile=$userId&info=uploadFailed"
                            );
                        }

                        //
                    } else {
                        header(
                            "Location: profile.php?profile=$userId&info=resolution"
                        );
                    }
                } else {
                    header(
                        "Location: profile.php?profile=$userId&info=oversized"
                    );
                }
            } else {
                header("Location: profile.php?profile=$userId&info=extension");
            }
        } else {
            echo "ce n'est pas VOTRE profil, bas les pattes";
        }
    }
}

//modification du profil

if (isset($_POST['userIdAModifier']) && $_POST['userIdAModifier'] != '') {
    $userId = $_POST['userIdAModifier'];
    if ($_SESSION['userId'] == $userId) {
        $newDisplayName = $_POST['display_name'];
        $newEmail = $_POST['email'];

        $maRequete = "UPDATE users SET display_name = '$newDisplayName', email = '$newEmail' WHERE id = $userId";

        $resultatRequeteUpdateProfil = mysqli_query($maConnection, $maRequete);
        if (!$resultatRequeteUpdateProfil) {
            die(mysqli_error($maConnection));
        } else {
            header("Location: profile.php?profile=$userId&info=edited");
        }
    } else {
        die("vous n'avez pas le droit de modifier ce profil");
    }
}

// Affichage de profil

if (
    (isset($_GET['profile']) && $_GET['profile'] != '') ||
    (isset($_POST['profileEdit']) && $_POST['profileEdit'] != '')
) {
    if (isset($_POST['profileEdit'])) {
        $userId = $_POST['profileEdit'];
        $maRequeteProfile = "SELECT id, username, display_name, email,images FROM users WHERE id = '$userId'";
    } else {
        $userId = $_GET['profile'];
        $maRequeteProfile = "SELECT username, display_name, email,images FROM users WHERE id = '$userId'";
    }

    $resultatRequeteProfil = mysqli_query($maConnection, $maRequeteProfile);

    if ($isLoggedIn && $_SESSION['userId'] == $userId) {
        $isUser = true;
    }
}

//Suppression d'un article

if (isset($_POST['idSuppression'])) {
    $idASupprimer = $_POST['idSuppression'];

    if (
        $isLoggedIn &&
        verifyOwnership($_SESSION['userId'], $idASupprimer, $maConnection)
    ) {
        $maRequeteDeSuppression = "DELETE FROM posts WHERE id=$idASupprimer";

        $maSuppression = mysqli_query($maConnection, $maRequeteDeSuppression);

        header('Location: ../index.php');
    } else {
        header('Location: ../index.php?info=pasLeDroit');
    }
}

// modification d'un article

if (isset($_POST['titreEdite']) && isset($_POST['texteEdite'])) {
    $titreEdite = $_POST['titreEdite'];

    $texteEdite = $_POST['texteEdite'];

    //on doit refaire passer l'ID par le biais d'un input supplémentaire dans le
    $idArticleAModifier = $_POST['idAModifier'];

    //  if($isLoggedIn && verifyOwnership($userId, $postId) ){
    if (
        $isLoggedIn &&
        verifyOwnership($_SESSION['userId'], $idArticleAModifier, $maConnection)
    ) {
        $maRequeteUpdate = "UPDATE posts SET title  = '$titreEdite', content = '$texteEdite' WHERE id = $idArticleAModifier";

        $monResultat = mysqli_query($maConnection, $maRequeteUpdate);

        header(
            "Location: postUnique.php?postId=$idArticleAModifier&info=edited"
        );
    } else {
        header(
            "Location: postUnique.php?postId=$idArticleAModifier&info=pasLeDroit"
        );
    }
}

//creation d'article

if (isset($_POST['nouveauTitre']) && isset($_POST['nouveauTexte'])) {
    if ($_POST['nouveauTitre'] !== '' && $_POST['nouveauTexte'] !== '') {
        $nouveauTitre = $_POST['nouveauTitre'];
        $nouveauTexte = $_POST['nouveauTexte'];
        $authorId = $_SESSION['userId'];
        //requete par defaut
        $maRequete = "INSERT INTO posts(title, content, author_id, images) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', 'default2.jpeg')";

        $statusUpload = 'default';
        // si il y a upload de photo
        if (
            isset($_FILES['uploadPostPic']['name']) &&
            $_FILES['uploadPostPic']['name'] != ''
        ) {
            $extensionsAutorisees = ['jpeg', 'jpg', 'png'];

            $hauteurMax = 720;
            $largeurMax = 900;

            $tailleMax = 3000000;

            $repertoireUpload = '../images/posts/';

            $nomTemporaireFichier = $_FILES['uploadPostPic']['tmp_name'];
            var_dump($nomTemporaireFichier);

            $mesInfos = getimagesize($_FILES['uploadPostPic']['tmp_name']);

            if ($mesInfos) {
                $monTableauExtensions = explode('/', $mesInfos['mime']);
                $extensionUploadee = $monTableauExtensions[1];

                $unTableau = explode('/', $nomTemporaireFichier);

                $nomTemporaireSansChemin = end($unTableau);

                $nomFinalDuFichier =
                    $nomTemporaireSansChemin . '.' . $extensionUploadee;

                $destinationFinale = $repertoireUpload . $nomFinalDuFichier;

                $maLargeur = $mesInfos[0];
                $maHauteur = $mesInfos[1];

                $maTaille = $_FILES['uploadPostPic']['size'];

                if (in_array($extensionUploadee, $extensionsAutorisees)) {
                    if ($maTaille <= $tailleMax) {
                        if (
                            $maLargeur <= $largeurMax &&
                            $maHauteur <= $hauteurMax
                        ) {
                            if (
                                move_uploaded_file(
                                    $nomTemporaireFichier,
                                    $destinationFinale
                                )
                            ) {
                                $statusUpload = 'added';
                                $maRequete = "INSERT INTO posts(title, content, author_id, images) VALUES ('$nouveauTitre', '$nouveauTexte', '$authorId', '$nomFinalDuFichier')";
                            } else {
                                $statusUpload = 'failed';
                            }

                            //
                        } else {
                            $statusUpload = 'resolution';
                        }
                    } else {
                        $statusUpload = 'oversized';
                    }
                } else {
                    $statusUpload = 'extension';
                }
            } else {
                $statusUpload = 'notAPicture';
            }
        }

        $leResultatDeMonAjoutArticle = mysqli_query($maConnection, $maRequete);

        // TEST qu ne doit pas etre visible pour les uilisateurs
        if (!$leResultatDeMonAjoutArticle) {
            die('RAPPORT ERREUR ' . mysqli_error($maConnection));
        }
        //    die($statusUpload);
        header("Location: ../index.php?info=$statusUpload");
    } else {
        echo 'remplis ton formulaire en entier';
    }
}

//effectuer une requete pour un article spécifique:
if (isset($_GET['postId']) || isset($_POST['postId'])) {
    if (isset($_GET['postId'])) {
        $postId = $_GET['postId'];
    } else {
        $postId = $_POST['postId'];
    }
    if ($isLoggedIn) {
        if (verifyOwnership($_SESSION['userId'], $postId, $maConnection)) {
            $isOwner = true;
        }
    }

    $maRequeteArticleUnique = "SELECT * FROM posts WHERE id=$postId";

    $leResultatDeMaRequeteArticleUnique = mysqli_query(
        $maConnection,
        $maRequeteArticleUnique
    );

    $mesCommentaires = getCommentsByPostId($postId, $maConnection);
} elseif (isset($_POST['myPosts']) && $isLoggedIn) {
    $userId = $_SESSION['userId'];

    $maRequete = "SELECT posts.id,posts.author_id,posts.images,posts.title,posts.content,users.username,users.display_name FROM posts 
    INNER JOIN users ON posts.author_id = users.id
    WHERE posts.author_id ='$userId'";

    $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
} else {
    //effectuer une requete SQL pour récupérer TOUS les posts

    $maRequete = "SELECT posts.images, posts.title, posts.content, posts.id, posts.author_id, users.display_name, users.username
                     FROM posts
                     INNER JOIN users
                     ON users.id = posts.author_id
                     WHERE posts.published = 1";

    $leResultatDeMaRequete = mysqli_query($maConnection, $maRequete);
}

// poster un commentaire

if (isset($_POST['comment']) && $_POST['comment'] != '' && $isLoggedIn) {
    $commentContent = $_POST['comment'];
    $postToComment = $_POST['postToComment'];
    $commentAuthor = $_POST['commentAuthor'];

    if ($commentAuthor == $_SESSION['userId'] && $postToComment != '') {
        $maRequete = "INSERT INTO comments(content, author_id, post_id) 
               VALUES ('$commentContent', '$commentAuthor', '$postToComment')";

        $resultat = mysqli_query($maConnection, $maRequete);

        if ($resultat) {
            header(
                "Location: postUnique.php?postId=$postToComment&info=commented"
            );
        } else {
            die(mysqli_error($maConnection));
        }
    }
}

function verifyOwnership($userId, $postId, $maConnection)
{
    //on veut comparer l'userId au author_id

    //a partir du postId faire une requete SQL pour récurérer l'author_id
    //et comparer l'userId de la session à cet author_id récupéré directement depuis la BDD
    //et regler $ownerVerified sur true ou false en fonction de cela

    $maRequeteDeVerification = "SELECT * FROM posts WHERE id = '$postId'";

    $resultatRequeteVerification = mysqli_query(
        $maConnection,
        $maRequeteDeVerification
    );

    foreach ($resultatRequeteVerification as $value) {
        $authorId = $value['author_id'];
    }

    $ownerVerified = false;

    if ($userId == $authorId) {
        $ownerVerified = true;
    }

    if ($ownerVerified) {
        return true;
    } else {
        return false;
    }
}
//Page admin suppression d'un user
if (isset($_POST['adminUserDel']) && $_POST['adminUserDel'] != '' && $isAdmin) {
    $idASupprimer = $_POST['adminUserDel'];
    $requeteSupprpostUser = "DELETE FROM `posts` WHERE author_id=$idASupprimer";
    $del = mysqli_query($maConnection, $requeteSupprUser);
    $requeteSupprUser = "DELETE FROM `users` WHERE id=$idASupprimer=$idASupprimer";
    $del = mysqli_query($maConnection, $requeteSupprUser);

    if (!$del) {
        die(mysqli_error($maConnection));
    }
}

//Page admin suppression d'un post
if (isset($_POST['adminPostDel']) && $_POST['adminPostDel'] != '' && $isAdmin) {
    $idASupprimer = $_POST['adminPostDel'];
    $requeteSuprPost = "DELETE FROM posts WHERE id=$idASupprimer";
    $del = mysqli_query($maConnection, $requeteSuprPost);
    if (!$del) {
        die(mysqli_error($maConnection));
    }
}

//Page admin recuperation des  posts
if (isset($_GET['adminPage']) && $isAdmin) {
    $reqeteTousPost = "SELECT posts.id, posts.title, posts.published, users.display_name, users.username
    FROM posts
    INNER JOIN users
    ON users.id = posts.author_id";
    $resultatmarequeteTousposts = mysqli_query($maConnection, $reqeteTousPost);
}
//Page admin unpublish

if (isset($_POST['adminPostUnPublish']) && $isAdmin) {
    $postToUnPublish = $_POST['adminPostUnPublish'];
    $req = "UPDATE posts SET published = '0' WHERE id = $postToUnPublish";
    $res = mysqli_query($maConnection, $req);
    header('Location: admin.php?adminPage=all');
}

//Page admin publish

if (isset($_POST['adminPostPublish']) && $isAdmin) {
    $postToPublish = $_POST['adminPostPublish'];
    $req = "UPDATE posts SET published = '1' WHERE id = $postToPublish";
    $res = mysqli_query($maConnection, $req);
    header('Location: admin.php?adminPage=all');
}

function getDisplayNameById($userId, $maConnection)
{
    $requete = "SELECT display_name FROM users WHERE id='$userId'";

    return var_dump(mysqli_query($maConnection, $requete));
}

function getCommentsByPostId($postId, $maConnection)
{
    $maREqueteComments = "SELECT comments.content, users.display_name, users.username 
                                 FROM comments 
                                 INNER JOIN users
                                 ON comments.author_id = users.id
                                 WHERE comments.post_id = '$postId'";

    $resultatRequeteComments = mysqli_query($maConnection, $maREqueteComments);

    return $resultatRequeteComments;
}

?>
