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
                        $eventController = new \controller\EventController();

                        $eventController->displayAlreadyCheckedCategoryWhenCreatingOneEvent();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Subcategory (optional):</label><br>
                    <div id="concertSubcat" style="display: block">
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
                    </div>

                    <div id="exhibitionSubcat" style="display: none">
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
                    </div>

                    <div id="conferenceSubcat" style="display: none">
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
                    </div>

                    <div id="hackathonSubcat" style="display: none">
                        <?php
                        $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(91, "musical");
                        ?>
                        <label for="musical"> Musical</label><br>
                        <?php
                        $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(101, "environmental2");
                        ?>
                        <label for="environmental2"> Environmental</label><br>
                        <?php
                        $eventController->displayAlreadyCheckedSubcategoriesWhenCreatingOneEvent(111, "social");
                        ?>
                        <label for="social"> Social</label><br>
                    </div>

                    <div id="gamejamSubcat" style="display: none">
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
                </div>

                <div class="form-group">
                    <label for="image_or_video">Upload an image or a video URL:</label>
                    <select name="image_or_video" class="form-control mb-3" id="image_or_video">
                        <?php
                        $eventController = new \controller\EventController();

                        $eventController->checkIfVideoOrImageOnEventCreation();
                        ?>
                    </select>
                    <div id="imageSubcat" style="display: block" class="ml-4">
                        <label for="image">Input image:</label>
                        <input type="file" name="image" id="imageInput" class="form-control-file mb-4">
                    </div>
                    <div id="videoSubcat" style="display: none" class="ml-4">
                        <label for="url">Input video URL:</label>
                        <input type="url" id="urlInput" name="url" class="form-control mb-4">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </form>
        </div>
    </div><!-- /.row -->

</main><!-- /.container -->

<script src="./public/js/main.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>