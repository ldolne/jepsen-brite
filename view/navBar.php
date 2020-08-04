<div class="nav-scroller py-1 mb-2">
  <nav class="nav d-flex justify-content-between">
      <a class="p-2 text-muted" href="index.php">Homepage</a>
      <a class="p-2 text-muted" href="index.php?action=allcategorycontroller">Events by category</a>
      <a class="p-2 text-muted" href="index.php?action=listPastEvents">Past Events</a>
    <?php if (!empty($_SESSION['username'])){?>
    <a class="p-2 text-muted" href="index.php?action=profile">Profile</a>
    <a class="p-2 text-muted" href="index.php?action=userdashboard">Dashboard</a>
    <?php } ?>
  </nav>
</div>