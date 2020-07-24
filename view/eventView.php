<?php $title = 'Event Page'; ?>

<?php ob_start(); ?>
<h1>Focus on event:</h1>
<p><a href="./index_laeti.php">Back to the homepage</a></p>

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

<div class="showComments">
    <h2>Comments</h2>

    <?php
    while ($comment = $comments->fetch())
    {
        ?>
        <p><strong><?= htmlspecialchars($comment['username']) ?></strong> on <?= $comment['comment_date_formatted'] ?></p>
        <p><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
        <?php
    }
    ?>
</div>

<div class="commentsForm">
    <h2>Commentaires</h2>

    <form action="./index_laeti.php?action=addComment&amp;id=<?= $event['id'] ?>" method="post">
        <div>
            <label for="author">Auteur</label><br />
            <input type="text" id="author" name="author" />
        </div>
        <div>
            <label for="comment">Commentaire</label><br />
            <textarea id="comment" name="comment"></textarea>
        </div>
        <div>
            <input type="submit" />
        </div>
    </form>
</div>

</body>
</html>
<?php
$eventReq->closeCursor();
$comments->closeCursor();
?>

<?php $content = ob_get_clean(); ?>

<?php require('template_laeti.php'); ?>
