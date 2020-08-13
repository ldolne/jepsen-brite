<?php $title = 'Modify Event'; ?>

<?php ob_start(); ?>
    <main role="main" class="container">
        <div class="row">

            <div class="col-md-12">

                <form role="form" action="./index.php?action=updateExistingEvent&amp;id=<?php
                if(isset($_POST['id'])){
                    echo $_POST['id'];
                } else {
                    echo $event['id'];
                } ?>" method="POST" enctype="multipart/form-data">
                    <h2>Modify an event</h2>
                    <div class="form-group">
                        <label for="title">Name:</label>
                        <input id="title" type="text" title="Max 80 characters" name="title" id="title" class="form-control" maxlength="80" value="<?php
                        if(isset($_POST['title'])){
                            echo htmlspecialchars($_POST['title']);
                        } else {
                            echo htmlspecialchars($event['title']);
                        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="event_date" id="date" class="form-control" value="<?php
                        if(isset($_POST['event_date'])){
                            echo $_POST['event_date'];
                        } else {
                            echo $event['event_date'];
                        } ?>">
                    </div>
                    <div class="form-group">
                        <label for="hour">Time:</label>
                        <input type="time" name="event_hour" id="hour" class="form-control" value="<?php
                        if(isset($_POST['event_hour'])){
                            echo $_POST['event_hour'];
                        } else {
                            echo $event['event_hour_formatted'];
                        } ?>">
                    </div>

                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input id="address" type="text"  name="address" id="address" class="form-control" value="<?php
                        if(isset($_POST['address'])){
                            echo htmlspecialchars($_POST['address']);
                        } else {
                            echo htmlspecialchars($event['address']);
                        } ?>">
                    </div>

                    <div class="form-group">
                        <label for="town">Town:</label>
                        <input id="town" type="text" name="town" id="town" class="form-control"  value="<?php
                        if(isset($_POST['town'])){
                            echo htmlspecialchars($_POST['town']);
                        } else {
                            echo htmlspecialchars($event['town']);
                        } ?>">
                    </div>
                        
                   
                    <div class="form-group">
                        <label for="cp">Zipcode:</label>
                        <input id="cp" type="text" name="cp" id="cp"  pattern="[0-9]{4}" title="Four digit zip code" class="form-control"  value="<?php
                        if(isset($_POST['cp'])){
                            echo htmlspecialchars($_POST['cp']);
                        } else {
                            echo htmlspecialchars($event['cp']);
                        } ?>">
                    </div>

                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" cols="33" class="form-control"><?php
                            if(isset($_POST['description'])){
                                echo htmlspecialchars($_POST['description']);
                            } else {
                                echo htmlspecialchars($event['description']);
                            } ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category_id" class="form-control" id="category">
                            <?php
                            $eventController = new \controller\EventController();

                            $eventController->displayAlreadyCheckedCategoryWhenModifyingOneEvent($event);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Subcategory (optional):</label><br>
                        <div id="concertSubcat" style="display: block">
                            <?php
                            $eventController = new \controller\EventController();

                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 1, "metal");
                            ?>
                            <label for="metal"> Metal</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 11, "classic");
                            ?>
                            <label for="classic"> Classic</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 21, "edm");
                            ?>
                            <label for="edm"> EDM</label><br>
                        </div>

                        <div id="exhibitionSubcat" style="display: none">
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 31, "contemporary_art");
                            ?>
                            <label for="contemporary_art"> Contemporary art</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 41, "photography");
                            ?>
                            <label for="photography"> Photography</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 51, "historical");
                            ?>
                            <label for="historical"> Historical</label><br>
                        </div>

                        <div id="conferenceSubcat" style="display: none">
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 61, "political");
                            ?>
                            <label for="political"> Political</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 71, "environmental");
                            ?>
                            <label for="environmental"> Environmental</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 81, "educational");
                            ?>
                            <label for="educational"> Educational</label><br>
                        </div>

                        <div id="hackathonSubcat" style="display: none">
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 91, "musical");
                            ?>
                            <label for="musical"> Musical</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 101, "environmental2");
                            ?>
                            <label for="environmental2"> Environmental</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 111, "social");
                            ?>
                            <label for="social"> Social</label><br>
                        </div>

                        <div id="gamejamSubcat" style="display: none">
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 121, "fps");
                            ?>
                            <label for="fps"> FPS</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 131, "rpg");
                            ?>
                            <label for="rpg"> RPG</label><br>
                            <?php
                            $eventController->displayAlreadyCheckedSubcategoriesWhenModifyingOneEvent($subcategories, 141, "moba");
                            ?>
                            <label for="moba"> MOBA</label><br>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image_or_video">Upload an image or a video URL:</label>
                        <select name="image_or_video" class="form-control mb-3" id="image_or_video">
                            <?php
                            $eventController = new \controller\EventController();

                            $eventController->checkIfVideoOrImage();
                            ?>
                        </select>
                        <div id="imageSubcat" style="display: block" class="ml-4">
                            <label for="image">Input image:</label>
                            <input type="file" name="image" id="image" class="form-control-file mb-4">
                        </div>
                        <div id="videoSubcat" style="display: none" class="ml-4">
                            <label for="url">Input video URL:</label>
                            <input type="url" id="url" name="url" class="form-control mb-4">
                        </div>
                    </div>
                        <div class="image-container">
                            <label for="imgEvent">Previous image:</label>
                            <div class="col-sm-8 p-4">
                                <?php if(strpos($event['image'], 'cloudinary.com') !== false) { ?>
                                    <div class="image-container">
                                        <image src="<?= $event['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" style="height: auto; object-fit: cover;">
                                    </div>
                                <?php } else { ?>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe src="<?= $event['image'] ?>" id="eventImageCards" alt="Event image" class="img-thumbnail img-responsive" width="100%" scrolling= "no"></iframe>
                                    </div>
                                <?php } ?>
                                <div class="ml-auto">
                                    <input type="button" class="btn btn-primary d-none" id="btnDiscard" value="Discard changes" />
                                </div>
                            </div>
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
