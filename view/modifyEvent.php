<?php $title = 'Modify event'; ?>

<?php ob_start(); ?>
    <main role="main" class="container">
        <div class="row">

            <div class="col-md-12">

                <form role="form" action="./index.php?action=updateExistingEvent&amp;id=<?= $event['id'] ?>" method="POST" enctype="multipart/form-data">
                    <h2>Modify event</h2>
                    <div class="form-group">
                        <label for="title">Name:</label>
                        <input id="title" type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" name="event_date" id="date" class="form-control" value="<?= htmlspecialchars($event['event_date']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="hour">Time:</label>
                        <input type="time" name="event_hour" id="hour" class="form-control" value="<?= htmlspecialchars($event['event_hour_formatted']) ?>">
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" rows="5" cols="33" class="form-control"><?= htmlspecialchars($event['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category:</label>
                        <select name="category_id" class="form-control" id="category">
                            <?php

                            switch($event['category_id'])
                            {
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

                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" id="image" class="form-control-file">
                        <div class="image-container">
                            <label for="imgProfile">Previous image:</label>
                            <img src="./public/img/events_img/<?= $event['image'] ?>" id="imgProfile" alt="Event image" style="width: 200px; height: 200px" class="img-thumbnail" width="150" />
                        </div>
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
