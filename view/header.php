<header class="blog-header py-4">
  <div class="row flex-nowrap justify-content-between align-items-center">
    <div class="col-4 pt-1">
      <?php 
        if (empty($_SESSION['username'])){
          ?>
      <a class="btn btn-sm btn-outline-secondary" href="index.php?action=connection">Log in</a>
      <?php
        }
        ?>
      <?php if (!empty($_SESSION['username'])){?>
      <a class="btn btn-sm btn-outline-secondary" href="index.php?action=deconnection">Log out</a>
      <?php } ?>
    </div>
    <div class="col-4 text-center">
      <a class="blog-header-logo text-dark" href="index.php">Jepsen Brite Team 5</a>
    </div>
    <div class="col-4 d-flex justify-content-end align-items-center">
      <?php 
        if (empty($_SESSION['username'])){
          ?>
      <a class="btn btn-sm btn-outline-secondary" href="index.php?action=inscription">Sign up</a>
      <?php
        }
        ?>
      <?php if (!empty($_SESSION['username'])){
          echo ("Bonjour " . $_SESSION['username']);} ?>
    </div>
  </div>
</header>