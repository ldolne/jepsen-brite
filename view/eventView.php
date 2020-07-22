<?php $title = 'Event Page'; ?>

<?php ob_start(); ?>
<h1>Focus on event:</h1>
<p><a href="./index_laeti.php">Back to the homepage</a></p>
<p><a href="./index_laeti.php?action=createEvent">Go to "Event creation page"</a></p>

<div class="event">
    <h3>
        <?= htmlspecialchars($event['title']) ?><br>
        by <?= htmlspecialchars($event['username']) ?><br>
        <em><?= htmlspecialchars($event['event_date_formatted']) ?></em><br>
        Category: <?= htmlspecialchars($event['category']) ?>
    </h3>
    <img src="" alt="">

    <p>
        <?= nl2br(htmlspecialchars($event['description'])) ?>
    </p>
</div>

<?php
$eventReq->closeCursor();
?>

<?php $content = ob_get_clean(); ?>

<?php require('template_laeti.php'); ?>