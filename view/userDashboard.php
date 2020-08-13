<?php $title = 'User Dashboard'; ?>

<?php ob_start(); ?>

<main role="main" class="container">

    <div class="row d-flex justify-content-between">

        <div class="card col-md-6 pr-1 pl-1">
                
            <div class="card-header d-flex justify-content-between">
                <h2>Events created</h2>
                <div class="mt-1">
                    <a href="./index.php?action=showEventCreationPage"><button class="btn btn-primary btn btn-block"> Create an event</button></a>
                </div>
            </div>

            <ul class="list-group list-group-flush">
                <?php
                    while ($data = $userEvents->fetch()) {
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-baseline">
                    <div>
                        <div class="d-inline-block mb-2 text-primary"><strong><?= $data['title'] ?></strong></div>
                            
                        <div class="mb-2 text-muted">
                            <?= $data['event_date_formatted'] ?>
                            <?= $data['event_hour_formatted'] ?>
                        </div>
                                
                        <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                    </div>

                    <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>">See this event</a>
                </li>
                <?php }
                    $userEvents->closeCursor(); 
                ?>
            </ul>

        </div>

        <div class="card col-md-6 pr-1 pl-1">
                
            <div class="card-header">
                <h2>Upcoming events participations</h2>
            </div>

            <ul class="list-group list-group-flush">
                <?php
                    while ($data = $upcomingParticip->fetch()) {
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-baseline">
                    <div>
                        <div class="d-inline-block mb-2 text-primary"><strong><?= $data['title'] ?></strong></div>
                            
                        <div class="mb-2 text-muted">
                            <?= $data['event_date_formatted'] ?>
                            <?= $data['event_hour_formatted'] ?>
                        </div>
                                
                        <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                    </div>

                    <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>">See this event</a>
                </li>
                <?php }
                    $upcomingParticip->closeCursor(); 
                ?>
            </ul>
                
            <div class="card-header">
                <h2>Past events participations</h2>
            </div>

            <ul class="list-group list-group-flush">
                <?php
                    while ($data = $pastParticip->fetch()) {
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-baseline">
                    <div>
                        <div class="d-inline-block mb-2 text-primary"><strong><?= $data['title'] ?></strong></div>
                            
                        <div class="mb-2 text-muted">
                            <?= $data['event_date_formatted'] ?>
                            <?= $data['event_hour_formatted'] ?>
                        </div>
                                
                        <div class="mb-2 text-muted"><?= $data['category'] ?></div>
                    </div>

                    <a href="./index.php?action=showEvent&amp;id=<?= $data['id'] ?>">See this event</a>
                </li>
                <?php }
                    $pastParticip->closeCursor(); 
                ?>
            </ul>
             
        </div>

    </div><!-- /.row -->
</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>