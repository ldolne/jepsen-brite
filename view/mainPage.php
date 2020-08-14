<?php $title = 'Homepage'; ?>

<?php ob_start(); ?>

<div class=" d-flex justify-content-between align-items-baseline mb-3 ml-4">
  <h2>Next upcoming event</h2>
  <div class="clo-md-2 ">
        <?php if (!empty($_SESSION['username'])) { ?>
            <p><em><a href="./index.php?action=showEventCreationPage"><button class="btn btn-primary btn-lg btn-block float-right">Create an event</button></a></em></p>
        <?php } ?>
    </div>
</div>



<div class="container">

  <div class="row">
    <div class="col-xs-12">
      <?php
      $counter = 1;
      while ($data = $events->fetch()) { //1
        if ($counter == 1) { //2
      ?>


          <div class="card">
            <div class="card-block">
              <div class="row">

                <div class="col-6">
                  <?php if (strpos($data['image'], 'cloudinary.com') !== false) { ?>
                    <image src="<?= $data['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" style="height: 14em; width: 100%; object-fit: cover;">
                    <?php } else { ?>
                      <image src="https://www.publicdomainpictures.net/pictures/260000/nahled/play-button-15282372642Gh.jpg" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" style="height: 14em; width: 100%; object-fit: cover;">
                    <?php } ?>
                </div>
                <div class="col-md-6">
                  <p>
                    <h3><strong class="d-inline-block mb-3 text-primary"><?= htmlspecialchars($data['title']) ?></strong></h3>
                  </p>
                  <div class="mb-2 text-muted"><?= $data['event_date_formatted'] ?> <?= $data['event_hour_formatted'] ?>
                  </div>
                  <p>
                    <?= htmlspecialchars($data['category']) ?>
                  </p>
                  <p>
                    <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>" class="stretched-link">Go to page of this
                      event</a>
                  </p>
                </div>

              </div>

            </div>

          </div>

          <h2 class="pb-3">Other next events</h2>


          <div class="card">
            <div class="bloc-card m-5">
              <div class="row mb-4">
              <?php
            } else {
              ?>
                <div class="col-md-3 mb-4">
                  <div class="row no-gutters rounded h-100">
                    <div class="card col p-2 m-2">
                      <div class="card-img-top">
                        <?php if (strpos($data['image'], 'cloudinary.com') !== false) { ?>
                          <image src="<?= $data['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" width="100%" style="height: 16rem; object-fit: cover;">
                          <?php } else {?>
                            <image src="https://www.publicdomainpictures.net/pictures/260000/nahled/play-button-15282372642Gh.jpg" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" width="100%" style="height: 16rem; object-fit: cover;">
                          <?php } ?>
                      </div>
                      <div class="card-body d-flex flex-column">
                        <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                        <strong class="d-inline-block mb-2 text-primary"><?= htmlspecialchars($data['title']) ?></strong>
                        <div class="mb-2 text-muted"><?= $data['event_date_formatted'] ?> <?= $data['event_hour_formatted'] ?></div>
                        <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>" class="stretched-link mt-auto">Go page of this event</a>
                      </div>
                    </div>
                  </div>
                </div>
            <?php
            }
            $counter++;
          } //1

          $events->closeCursor();
            ?>
              </div>
            </div>
          </div>
    </div>
  </div>
</div>






<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>