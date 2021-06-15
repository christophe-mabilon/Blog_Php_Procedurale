<?php include 'logique.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://bootswatch.com/5/solar/bootstrap.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
   

<?php require_once dirname(__FILE__) . '/../navbar.php'; ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 'edited') { ?>

<div class="alert alert-dismissible alert-success">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> You successfully edited <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 'pasLeDroit') { ?>

<div class="alert alert-dismissible alert-danger">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Well done!</strong> Vous n'avez pas le droit de modifier cet article <a href="#" class="alert-link">this article</a>.
</div>
<?php } ?>
    <div class="container mt-5 mx-0">



   
  <div class="container mx-0">
  
  
  

<?php foreach ($leResultatDeMaRequeteArticleUnique as $value) { ?>
                  
        <div class="row text-center">
        <div class="text-center">
            <img src="../images/posts/<?php echo $value[
                'images'
            ]; ?>" alt="" style="width:8rem;"></div>
        </div>

                  <div class="row text-center">
                  
                    <h2><?php echo $value['title']; ?></h2>
                  
                  
                  </div>
                  
                  <div class="text-center">
                      <p><?php echo $value['content']; ?></p>
                  </div>
                  
                    
                   
                   
            
    </div>
    </div>
    
    <?php if ($isLoggedIn && $isOwner) { ?>
            <div class="row">
            <div class="d-flex my-2 mx-0">
            <form action="edition.php" method="post">
              <button type="submit" name="postId" value="<?php echo $value[
                  'id'
              ]; ?>" class="btn btn-primary">Modifier</button>
            </form>

     <form class="ms-2" method="post">
      <input type="hidden" name="userId" value ="<?php echo $_SESSION[
          'userId'
      ]; ?>">
<?php if ($value['published']) { ?>


               <button type="submit" name="unPublish" value="<?php echo $value[
                   'id'
               ]; ?>" class="btn btn-danger">dé-publier</button>

       
           
        <?php } else { ?>   
</div>
              <button type="submit" name="publish" value="<?php echo $value[
                  'id'
              ]; ?>" class="btn btn-success">Publier</button>


        <?php } ?>
           
            </form>

            

</div>

     <?php } ?>

<?php } ?>

    
            <a href="/php/blog" class="container-fluid row m-0 btn btn-danger">Retour a l'accueil</a>
    

  <?php if ($isLoggedIn) { ?>
    <div class="container-fluid m-0">
    <h3>Poster votre commentaire</h3>
          <form method="post">
          <div class="form-group">
             <input type="text" name="comment" class="form-control" placeholder="Votre commentaire">
          </div>
            <input type="hidden" name="postToComment" value="<?php echo $postId; ?>">
            <input type="hidden" name="commentAuthor" value="<?php echo $_SESSION[
                'userId'
            ]; ?>">

          <div class="form-group">
          
                      <button type="submit" class="btn btn-success my-2">Poster le commentaire</button>

          </div>
          </form> 
    </div>
    <?php } ?>





    <hr>
          <?php foreach ($mesCommentaires as $comment) { ?>
    
              <div class="row">
                <p class="ms-2 btn btn-blue d-flex w-25"><strong>  <?php if (
                    $comment['display_name'] != ''
                ) {
                    echo $comment['display_name'];
                } else {
                    echo $comment['username'];
                } ?> </strong></p>
              
                  <p class="ms-2">  <?php echo $comment['content']; ?>  </p>
              </div>
              <hr>


            <?php } ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>