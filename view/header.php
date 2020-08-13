<header class="white-text-container section-container">
  <div class="text-right"> 
    <?php if (!empty($_SESSION['username'])) {
      echo ("Bonjour " . $_SESSION['username']);
    } ?></div>

  <div class="text-center">

    <h1>Welcome to the Jepsen-Brite</h1>
    <p>
      <a class="btn btn-sm btn-outline-secondary" href="index.php">
        Homepage </a>
      <a class="btn btn-sm btn-outline-secondary" href="index.php?action=showAllCategories">
        Events by category
      </a>
      <a class="btn btn-sm btn-outline-secondary" href="index.php?action=listPastEvents">
        Past Events
      </a>
      <?php if (!empty($_SESSION['username'])) { ?>
        <a class="btn btn-sm btn-outline-secondary" href="index.php?action=profile">Profile</a>
        <a class="btn btn-sm btn-outline-secondary" href="index.php?action=userdashboard">Dashboard</a>
      <?php } ?>
      <?php
      if (empty($_SESSION['username'])) {
      ?>
        <a class="btn btn-sm btn-outline-secondary" href="index.php?action=connection">Log in</a>
      <?php
      }
      ?>
      <?php if (!empty($_SESSION['username'])) { ?>
        <a class="btn btn-sm btn-outline-secondary" href="index.php?action=deconnection">Log out</a>
      <?php } ?>
      <?php
      if (empty($_SESSION['username'])) {
      ?>
        <a class="btn btn-sm btn-outline-secondary" href="index.php?action=inscription">Sign up</a>
      <?php
      }
      ?>

    </p>
  </div>
</header>