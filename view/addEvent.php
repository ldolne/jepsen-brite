<?php $title = 'Add event'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">
        <div class="col-md-12">
            <form role="form" action="./index.php?action=createNewEvent" method="POST" enctype="multipart/form-data">
                <h2>Add event</h2>
                <div class="form-group">
                    <label for="title">Name:</label>
                    <input id="title" title="Max 80 characters" type="text" maxlength="80" name="title" id="title" class="form-control" value="<?php if (isset($_POST['title'])) {
                                                                                                                                                    echo $_POST['title'];
                                                                                                                                                } ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" name="event_date" id="date" class="form-control" value="<?php if (isset($_POST['event_date'])) {
                                                                                                    echo $_POST['event_date'];
                                                                                                } ?>">
                </div>
                <div class="form-group">
                    <label for="hour">Time:</label>
                    <input type="time" name="event_hour" id="hour" class="form-control" value="<?php if (isset($_POST['event_hour'])) {
                                                                                                    echo $_POST['event_hour'];
                                                                                                } ?>">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="description" rows="5" cols="33" class="form-control"><?php if (isset($_POST['description'])) {
                            echo $_POST['description'];
                        } ?></textarea>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category_id" class="form-control" id="category">
                        <?php
                        if (isset($_POST['category_id'])) {
                            switch ($_POST['category_id']) {
                                case 1:
                        ?>
                                    <option value="1" selected>Concert</option>
                                    <option value="2">Exhibition</option>
                                    <option value="3">Conference</option>
                                    <option value="4">Hackathon</option>
                                    <option value="5">Game Jam</option>
                                <?php
                                    break;
                                case 2:
                                ?>
                                    <option value="1">Concert</option>
                                    <option value="2" selected>Exhibition</option>
                                    <option value="3">Conference</option>
                                    <option value="4">Hackathon</option>
                                    <option value="5">Game Jam</option>
                                <?php
                                    break;
                                case 3:
                                ?>
                                    <option value="1">Concert</option>
                                    <option value="2">Exhibition</option>
                                    <option value="3" selected>Conference</option>
                                    <option value="4">Hackathon</option>
                                    <option value="5">Game Jam</option>
                                <?php
                                    break;
                                case 4:
                                ?>
                                    <option value="1">Concert</option>
                                    <option value="2">Exhibition</option>
                                    <option value="3">Conference</option>
                                    <option value="4" selected>Hackathon</option>
                                    <option value="5">Game Jam</option>
                                <?php
                                    break;
                                case 5:
                                ?>
                                    <option value="1">Concert</option>
                                    <option value="2">Exhibition</option>
                                    <option value="3">Conference</option>
                                    <option value="4">Hackathon</option>
                                    <option value="5" selected>Game Jam</option>
                            <?php
                                    break;
                            }
                        } else {
                            ?>
                            <option value="1" selected>Concert</option>
                            <option value="2">Exhibition</option>
                            <option value="3">Conference</option>
                            <option value="4">Hackathon</option>
                            <option value="5">Game Jam</option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Subcategory (optional):</label><br>
                    <?php
                    $eventController = new \controller\EventController();

                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(1, "metal");
                    ?>
                    <label for="metal"> Metal</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(11, "classic");
                    ?>
                    <label for="classic"> Classic</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(21, "edm");
                    ?>
                    <label for="edm"> EDM</label><br>

                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(31, "contemporary_art");
                    ?>
                    <label for="contemporary_art"> Contemporary art</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(41, "photography");
                    ?>
                    <label for="photography"> Photography</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(51, "historical");
                    ?>
                    <label for="historical"> Historical</label><br>

                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(61, "political");
                    ?>
                    <label for="political"> Political</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(71, "environmental");
                    ?>
                    <label for="environmental"> Environmental</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(81, "educational");
                    ?>
                    <label for="educational"> Educational</label><br>

                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(91, "musical");
                    ?>
                    <label for="musical"> Musical</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(101, "environmental");
                    ?>
                    <label for="environmental"> Environmental</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(111, "social");
                    ?>
                    <label for="social"> Social</label><br>

                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(121, "fps");
                    ?>
                    <label for="fps"> FPS</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(131, "rpg");
                    ?>
                    <label for="rpg"> RPG</label><br>
                    <?php
                    $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(141, "moba");
                    ?>
                    <label for="moba"> MOBA</label><br>
                </div>
                <div class="form-group">
                    <label for="image">Image:</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div><!-- /.row -->

</main><!-- /.container -->

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>