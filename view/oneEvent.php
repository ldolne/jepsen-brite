<?php $title = htmlspecialchars($event['title']) ?>

<?php ob_start(); ?>
<?php
require('./vendor/erusev/parsedown/Parsedown.php');
$parsdown = new Parsedown();
?>
<div class=" d-flex justify-content-between align-items-baseline">
  <h1 class="text-wrap" style="max-width:90rem; word-break: break-word;">  <?= htmlspecialchars($event['title']) ?></h1>
  <div class="clo-md-2 ">
        <?php if (!empty($_SESSION['username'])) { ?>
            <p><em><a href="./index.php?action=showEventCreationPage"><button class="btn btn-primary btn-lg btn-block float-right">Create an event</button></a></em></p>
        <?php } ?>
    </div>
</div>
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body ml-5">
                <div class="card-title mb-4 mt-5">
                    <?php if (
                        !empty($_SESSION['username'])
                        and ($event['event_date'] > date('Y-m-d')
                            or ($event['event_date'] == date('Y-m-d') and ($event['event_hour'] > date('h:i:s', time() + 2 * 3600))))
                    ) { // + 2 hours because of the server location

                        $isParticipating = false;

                        foreach ($participantsArr as $participant) {
                            if ($_SESSION['id'] == $participant['id']) {
                                $isParticipating = true;
                            }
                        }

                        if ($isParticipating == true) {
                    ?>
                            <div class="row mb-3">
                                <div class="col-sm-3 col-md-2 col">
                                    <a href="./index.php?action=unregisterFromEvent&amp;id=<?= $event['id'] ?>">
                                        <button class="btn btn-secondary">Participating</button>
                                    </a>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="row mb-3">
                                <div class="col-sm-3 col-md-2 col-5">
                                    <a href="./index.php?action=registerToEvent&amp;id=<?= $event['id'] ?>">
                                        <button class="btn btn-primary">Participate</button>
                                    </a>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="d-flex justify-content-start">
                        <div class="col-sm-8 p-4">
                            <?php if (strpos($event['image'], 'cloudinary.com') !== false) { ?>
                                <div class="image-container">
                                    <image src="<?= $event['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" style="height: auto; object-fit: cover;">
                                </div>
                            <?php } else { ?>
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe src="<?= $event['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" width="100%" scrolling="no"></iframe>
                                </div>
                            <?php } ?>
                            <div class="ml-auto">
                                <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard changes" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="tab-content ml-1" id="myTabContent">
                            <div class="" id="basicInfo" role="tabpanel" aria-labelledby="basicInfo-tab">
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
                                    <div class="col-sm-3 col-md-2 col-5 pb-3">
                                        <label style="font-weight:bold;">Place</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?php echo $event['address'] . ' ' . $event['town'] . ' ' . $event['cp']; ?>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <iframe src="https://www.google.com/maps?q=<?= $event['address'] . ' ' . $event['cp']; ?>  &output=embed" width="500" height="450" frameborder="0" style="border:0; margin-left:11em;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                                    </div>

                                </div>
                                <hr />

                                
                                <div class="row">
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Description</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?= $parsdown->text(nl2br(htmlspecialchars($event['description']))) ?>
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
                                        <label style="font-weight:bold;">Subcategory</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?php
                                        if (!empty($subcategoriesArr)) {
                                            echo "<ul>";
                                            foreach ($subcategoriesArr as $subcategory) {
                                        ?>
                                                <li style="List-style-type: disc;"><?= htmlspecialchars($subcategory['subcategory']) ?></li>
                                        <?php
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "None";
                                        }
                                        ?>
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
                                    <div class="col-sm-3 col-md-2 col-5">
                                        <label style="font-weight:bold;">Participants:</label>
                                    </div>
                                    <div class="col-md-8 col-6">
                                        <?php
                                        if (!empty($participantsArr)) {
                                            echo "<ul>";
                                            foreach ($participantsArr as $participant) {
                                        ?>
                                                <li style="List-style-type: disc;"><?= htmlspecialchars($participant['username']) ?></li>
                                        <?php
                                            }
                                            echo "</ul>";
                                        } else {
                                            echo "None. Be the first one to take part in this event!";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <hr />

                                <div class="row mb-3">
                                    <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $event['author_id']) {
                                    ?>
                                        <div class="col-sm-3 col-md-2 col-5">
                                            <a href="./index.php?action=showEventModificationPage&amp;id=<?= $event['id'] ?>">
                                                <button class="btn btn-warning">Modify event</button>
                                            </a>
                                        </div>
                                    <?php
                                    } ?>
                                    <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $event['author_id'] || !empty($_SESSION['id']) && $isAdmin != "0") {
                                    ?>
                                        <div class="col-md-8 col-6">
                                            <a href="./index.php?action=deleteExistingEvent&amp;id=<?= $event['id'] ?>" onclick="if(!confirm('Are you sure you want to delete this event?')) return false;">
                                                <button class="btn btn-danger">Delete event</button>
                                            </a>
                                        </div>
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
        <div class="card mt-5">
            <div class="mt-5">
                <?php
                while ($comment = $comments->fetch()) {
                ?>
                    <div class="card-body ml-5">
                        <div class="row">
                            <div class="col-sm-3 col-md-2 col-5">
                                <div class="image-container">
                                    <img src="https://www.gravatar.com/avatar/<?= $comment['avatar'] ?>" id="imgProfile" alt="User image" class="img-thumbnail" width="50" />
                                </div>
                                <label style="font-weight:bold;"><?= htmlspecialchars($comment['username']) ?></label>
                            </div>
                            <div class="col-sm-3 col-md-2 col-5">
                                <label style="font-weight:bold;"><?= $comment['comment_date_formatted'] ?></label>
                            </div>
                            <div class="d-flex justify content-between col-8">
                                <div class="col-sm-3 col-md-8 col-6">
                                <?= $parsdown->text(nl2br(htmlspecialchars($comment['comment']))) ?>
                            </div>
                            <?php if (!empty($_SESSION['id']) && $_SESSION['id'] == $comment['author_id'] || !empty($_SESSION['id']) && $isAdmin != "0") {
                            ?>
                                    <a href="./index.php?action=deleteExistingComment&amp;id=<?= $event['id'] ?>&amp;comment_id=<?= $comment['id'] ?>" onclick="if(!confirm('Are you sure you want to delete this comment?')) return false;">
                                        <button class="btn btn-danger">Delete comment</button>
                                    </a>
                            <?php
                            } ?>
                            </div>
                        </div>
                    </div>
                    <hr />
                <?php
                }
                ?>
                <?php if (!empty($_SESSION['username'])) {
                ?>
                    <form role="form" action="./index.php?action=addComment&amp;id=<?= $event['id'] ?>" method="post">
                        <div class="card-body ml-5">
                            <div class="row mb-4">
                                <div class="col-sm-3 col-md-2 col-5 ">
                                    <div class="image-container">
                                        <img src="https://www.gravatar.com/avatar/<?= $userAvatar['avatar'] ?>" id="imgProfile" alt="User image" class="img-thumbnail" width="50" />
                                    </div>
                                    <label for="comment" style="font-weight:bold;">Add comment</label>
                                </div>
                                <textarea id="comment" name="comment" class="col-md-8 col-6"></textarea>
                                <div class="m-4">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
$eventReq->closeCursor();
$participants->closeCursor();
$comments->closeCursor();
$subcategories->closeCursor();
?>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>