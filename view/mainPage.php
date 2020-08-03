<?php $title = 'Homepage'; ?>

<?php ob_start(); ?>

  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">The best events of your region only a click away!</h1>
      <p class="lead my-3">
        All the biggest events in your region can be found here.</p>
    </div>
  </div>
  <div>
    <h1>Next upcoming event</h1>
  </div>

  <?php
  $counter = 1;
  while ($data = $events->fetch()) {
    if ($counter == 1) {
  ?>
    <div class="row mb-1">
        <div class="col-md-10">
            <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-100 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <div class="card-text mb-auto">
                        <img src="./public/img/events_img/<?= $data['image'] ?>" id="imgProfile" alt="Event image" class="img-thumbnail" width="150" />
                    </div>
                    <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                    <strong class="d-inline-block mb-2 text-primary"><?= htmlspecialchars($data['title']) ?></strong>
                    <div class="mb-2 text-muted"><?= $data['event_date_formatted'] ?> <?= $data['event_hour_formatted'] ?></div>
                    <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>" class="stretched-link">Go page of this event</a>
                </div>
            </div>
        </div>
        <div class="clo-md-2">
            <?php if (!empty($_SESSION['username'])) { ?>
                <p><em><a href="./index.php?action=showEventCreationPage"><button class="btn btn-primary btn-lg btn-block"> Create an event</button></a></em></p>
            <?php } ?>
        </div>
    </div>
  <div class="row mb-4">
<?php
  }
  else
  {
?>
      <div class="col-md-3">
          <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
              <div class="col p-4 d-flex flex-column position-static">
                  <div class="card-text mb-auto">
                      <img src="./public/img/events_img/<?= $data['image'] ?>" id="imgProfile" alt="Event image" class="img-thumbnail" width="100" />
                      <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                      <strong class="d-inline-block mb-2 text-primary"><?= htmlspecialchars($data['title']) ?></strong>
                      <div class="mb-2 text-muted"><?= $data['event_date_formatted'] ?> <?= $data['event_hour_formatted'] ?></div>
                      <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>" class="stretched-link">Go page of this event</a>
                  </div>
              </div>
          </div>
      </div>
    <?php
    }
    $counter++;
  }

  $events->closeCursor();
    ?>
</div>
      <?php $content = ob_get_clean(); ?>
      <?php require('template.php'); ?>