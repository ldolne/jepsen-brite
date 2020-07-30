<?php $title = 'One event'; ?>

<?php ob_start(); ?>
<?php
require('./vendor/erusev/parsedown/Parsedown.php');
$parsdown = new Parsedown();
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title mb-4">
                    <div class="d-flex justify-content-start">
                        <div class="image-container">
                            <img src="./public/img/events_img/<?= $event['image'] ?>" id="imgProfile" alt="Event image" style="width: 200px; height: 200px" class="img-thumbnail" width="150" />
                        </div>
                        <div class="ml-auto">
                            <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard Changes" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="tab-pane fade show active" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">

                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Name</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= htmlspecialchars($event['title']) ?>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Date</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= htmlspecialchars($event['event_date_formatted']) ?>
                                    </div>
                                </div>
                                <hr />


                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Hour</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= htmlspecialchars($event['event_hour_formatted']) ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Category</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= htmlspecialchars($event['category']) ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Description</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= nl2br(htmlspecialchars($event['description'])) ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Event's Author</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= htmlspecialchars($event['username']) ?>
                                    </div>
                                </div>
                                <hr />

                                <div class="row">
                                    <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                                    ?>
                                        <a href="./index.php?action=showEventModificationPage&amp;id=<?= $event['id'] ?>">
                                            <button class="btn btn-primary">Modify event</button>
                                        </a>
                                        <a href="./index.php?action=deleteExistingEvent&amp;id=<?= $event['id'] ?>">
                                            <button class="btn btn-danger">Delete event</button>
                                        </a>
                                    <?php
                                    } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">

            <?php
            while ($comment = $comments->fetch()) {
            ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3 col-md-2 col-5">
                            <label style="font-weight:bold;"><?= htmlspecialchars($comment['username']) ?></label>
                        </div>
                        <div class="col-sm-3 col-md-2 col-5">
                            <label style="font-weight:bold;"><?= $comment['comment_date_formatted'] ?></label>
                        </div>
                        <div class="col-md-8 col-6">
                            <?= htmlspecialchars($comment['comment']) ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <?php if (!empty($_SESSION['username'])) {
            ?>
                <form role="form" action="./index.php?action=addComment&amp;id=<?= $event['id'] ?>" method="post">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 col-md-2 col-5 ">
                                <label for="comment" style="font-weight:bold;">Add comment</label>
                            </div>
                           <?php  echo $parsdown->text  (' <textarea id="comment" name="comment" class="col-md-8 col-6"></textarea>')?>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<?php
$eventReq->closeCursor();
$comments->closeCursor();
?>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>