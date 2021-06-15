<?php

require 'blog/logique.php'; ?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
<?php require_once 'navbar.php'; ?>

<?php if (isset($_GET['info']) && $_GET['info'] == 'registered') { ?>

<div class="alert alert-success" role="alert">
Successfully registered !
</div>


<?php } ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 'added') { ?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully posted with a picture<a href="#" class="alert-link">a new article</a>.
</div>
<?php } ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 'default') { ?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully posted but no picture<a href="#" class="alert-link">a new article</a>.
</div>
<?php } ?>






<?php if (isset($_GET['info']) && $_GET['info'] == 'deleted') { ?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully deleted <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 'pasLeDroit') { ?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Nope</strong> Vous n'avez pas le droit de supprimer cet article <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>

    <div class="container">
    
    
        <div class="row mt-5">
        <?php if ($modeInscription) { ?>
            <small class="text-white"><?php echo $message; ?></small>       
<form method="post">

<div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="usernameSignUp">
</div>

<div class="form-group">
<label for="password">password</label>
    <input type="password" class="form-control" name="passwordSignUp">
</div>  

<div class="form-group">
<label for="passwordRetype">Re-type password</label>
    <input type="password" class="form-control" name="passwordRetypeSignUp">
</div>  

<div class="form-group">
<label for="displayNameSignup">Nom a afficher</label>
<input type="text" class="form-control" name="displayNameSignup">
</div>

<div class="form-group">
<label for="emailSignUp">email</label>
<input type="email" class="form-control" name="emailSignUp">
</div>

    
</div>     

    <div class="form-group">
    <input type="hidden" name="modeInscription" value="on">
     <input type="submit" value="Sign up" class="btn btn-success m-1 ">
    </div>

</form>

<form method="POST">
<button class="btn btn-primary m-1" name="modeInscription" value="off">Se connecter</button>
</form>

<?php } else { ?>
    <div class="container-fluid"></div>


            <?php //debut de la boucle
            foreach ($leResultatDeMaRequete as $post) { ?>
                      
                    <div class="col-4 align-items-stretch m-auto">
                    
                            <div class="card text-white violet mb-3 align-items-stretch m-auto" >
                            <div class=" text-center"><img src="images/posts/<?php echo $post[
                                'images'
                            ]; ?>" alt=""></div>

                            <div class="card-header text-center"><h4><?php echo $post[
                                'title'
                            ]; ?></h4></div>
                            <div class="card-body">
                               <h4 class="text-white card-title">
                               <a style="color : black" href="<?php echo $racineSite; ?>/blog/profile.php?profile=<?php echo $post[
    'author_id'
]; ?>"></a></h4> <p>Auteur : <?php if ($post['display_name'] != '') {
    echo $post['display_name'];
} else {
    echo $post['username'];
} ?></p>
                                <p class="card-text"><?php echo $post[
                                    'content'
                                ]; ?></p>
                            </div>
                            
                                 <a href ="blog/postUnique.php?postId=<?php echo $post[
                                     'id'
                                 ]; ?>" class="btn btn-blue">Voir l'article</a>
                                 </div>
                    </div>
                
               <?php } ?> 
</div>

<?php } ?>
</div>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>