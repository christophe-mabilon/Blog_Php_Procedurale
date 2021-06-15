<?php require_once 'logique.php'; ?>
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
<?php
require_once dirname(__FILE__) . '/../navbar.php';

if ($isAdmin) { ?>


    <!--<p>salut admin</p>

 la liste de tous les posts et pour chaque post : <br>
-un lien vers l'affichage du post<br>
-un bouton publier/dépublier fonctionnel<br>
-un bouton supprimer<br>

la liste de tous les users sauf l'admin lui-même, et pour chaque user  <br>

-un bouton -->
<h2 class="text-center text-white">Tableau Admin</h2>
<table class="table table-striped text-center">
  
    <thead>
<tr class="text-white">
      
      <th scope="col">User</th>
      <th scope="col">Post</th>
      <th scope="col">Publier/Dépublier un post</button></th>
      <th scope="col">Suppression Post</button></th>
      <th scope="col">Suppression User</button></th>
    </tr>
    </thead>
<?php foreach ($resultatmarequeteTousposts as $key => $value) { ?>
    <tbody>
    <tr>
      <td><p class="text-white text-decoration-none"><?php if (
          $value['display_name'] !== ''
      ) {
          echo $value['display_name'];
      } else {
          echo $value['username'];
      } ?></p></td>
      <td><a class="text-blue" href="<?php echo $racineSite .
          '/blog/postUnique.php?postId=' .
          $value['id']; ?>" class=""><?php echo $value['title']; ?></a></td>
      <td><?php if ($value['published'] == 1) { ?>
          <form method="POST"><button type="submit" name="adminPostUnPublish" value="<?php echo $value[
              'id'
          ]; ?>" class="btn btn-info">dé-publier</button></form>

      <?php } else { ?>
        <form method="POST"><button type="submit" name="adminPostPublish" value="<?php echo $value[
            'id'
        ]; ?>" class="btn btn-success">Publier</button></form>

      <?php } ?>
      
      </td>      
      <td><form method="POST"><button type="submit" name="adminPostDel" value="<?php echo $value[
          'id'
      ]; ?>" class="btn btn-danger">Suppression Post</button></form></td>
      <td><form method="POST"><button type="submit" name="" value="<?php echo $value[
          'id'
      ]; ?>" class="btn btn-warning">Suppression User</button></form></td>
    </tr>
    <tr>
    </tr>
    </tbody>

 <?php } ?>
 
 <?php } else { ?>
    </tr>
  
</table>

    




    <p>vous n'etes pas administrateur</p>


   
    <?php }
?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

</body>
</html>