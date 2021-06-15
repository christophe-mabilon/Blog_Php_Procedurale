<nav class="navbar-expand-lg nav nav-pills nav-fill bg-dark">
  <div class="container-fluid d-flex align-items-center my-auto">
  <a class="navbar-brand fs-4" href="/">Mon Blog</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-tarPOST="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        
        <li class="nav-item">
          <a href="<?php echo $racineSite; ?>" class="nav-link text-white btn btn-dark my-2 my-sm-0" href="./">Home
            
          </a>
        </li>
        <?php if ($isLoggedIn) { ?>

        <li class="nav-item">
          <a class="nav-link text-white btn btn-dark my-2 my-sm-0" href="<?php echo $racineSite; ?>/blog/creation.php">Nouveau post</a>
        </li>
        <li>
        
        <form action="<?php echo $racineSite; ?>/index.php" method="POST" class="d-flex">
 
  <button type="submit" name="myPosts" class="btn btn-dark my-2 my-sm-0" >Mes Posts</button>
</form>

        
        </li>
        <li class="nav-item">
          <a class="nav-link text-white btn btn-dark my-2 my-sm-0 " href="<?php echo $racineSite; ?>/blog/profile.php?profile=<?php echo $_SESSION[
    'userId'
]; ?>">Mon Profil</a>
        </li>
        <li>
        <?php if ($isAdmin) { ?>
        
        <form action="<?php echo $racineSite; ?>/blog/admin.php">
        
          <button type="submit" class="btn btn-dark btn-primary my-2 my-sm-0" name="adminPage" value="all">Admin</button>
        
        </form>
        
        </li>
        
        <?php } ?>
                <?php } ?>
      
      </ul>
      
      <?php if (!$isLoggedIn && !$modeInscription) { ?>
        <form method="POST" class="d-flex align-items-center my-2">

            <div class="form-group mx-1">
            <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group mx-1">
            <input type="password" class="form-control" name="password" placeholder="Password"  required>
            </div>        
        
                <div class="form-group">
                 <input type="submit" value="Log in" class="btn btn-success m-2">
                </div>
        </form>
      

        <?php } ?>

        <?php if ($isLoggedIn) { ?>
              <div class="text-white d-block"><small><?php echo $loggedIn; ?></small>
            <h2 class="fs-5 me-3 indie">Bonjour  <?php if (
                $_SESSION['display_name'] == ''
            ) {
                echo $_SESSION['username'];
            } else {
                echo $_SESSION['display_name'];
            } ?></h2></div>

<form method="POST" class="d-flex">
 
  <button type="submit" name="logOut" class="btn btn-danger my-2 my-sm-0" >Deconnexion</button>
</form>

<?php } ?>


      <?php if (!$modeInscription && !$isLoggedIn) { ?>



      <form method="POST" class="d-flex">
       
        <button type="submit" name="modeInscription" value="on" class="btn btn-primary my-2 my-sm-0" type="submit">Inscription</button>
      </form>
      <?php } ?>
    </div>
  </div>
</nav>