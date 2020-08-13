<header class="white-text-container section-container">
  <div class="text-right">
    <?php if (!empty($_SESSION['username'])) {
      echo ("Bonjour " . $_SESSION['username']);
    } ?>
  <?php
  if (empty($_SESSION['username'])) {
  ?>
    <a class="btn btn-sm btn-outline-light" href="index.php?action=connection">Log in</a>
  <?php
  }
  ?>
  <?php if (!empty($_SESSION['username'])) { ?>
    <a href="index.php?action=deconnection"><button class="btn btn-sm btn-light ml-3"><div style="color: #ff0060;">Log out</div></button></a>
  <?php } ?>
  <?php
  if (empty($_SESSION['username'])) {
  ?>
    <a style="color: #ff0060;" href="index.php?action=inscription"><button class="btn btn-sm btn-light"><div style="color: #ff0060;">Sign up</div></button></a>
  <?php
  }
  ?></div>

  <div class="text-center">

    <h1>Welcome to Jepsen-Brite</h1>
    <p>
      <a class="btn btn-sm btn-outline-light" href="index.php">
        Homepage </a>
      <a class="btn btn-sm btn-outline-light" href="index.php?action=showAllCategories">
        Events by category
      </a>
      <a class="btn btn-sm btn-outline-light" href="index.php?action=listPastEvents">
        Past Events
      </a>
      <?php if (!empty($_SESSION['username'])) { ?>
        <a class="btn btn-sm btn-outline-light" href="index.php?action=profile">Profile</a>
        <a class="btn btn-sm btn-outline-light" href="index.php?action=userdashboard">Dashboard</a>
      <?php } ?>

    </p>
  </div>
</header>