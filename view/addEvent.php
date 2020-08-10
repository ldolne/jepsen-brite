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
                    <input type="checkbox" id="metal" name="subcategory_id[]" value="1">
                    <label for="metal"> Metal</label><br>
                    <input type="checkbox" id="classic" name="subcategory_id[]" value="11">
                    <label for="classic"> Classic</label><br>
                    <input type="checkbox" id="edm" name="subcategory_id[]" value="21">
                    <label for="edm"> EDM</label><br>

                    <input type="checkbox" id="contemporary_art" name="subcategory_id[]" value="31">
                    <label for="contemporary_art"> Contemporary art</label><br>
                    <input type="checkbox" id="photography" name="subcategory_id[]" value="41">
                    <label for="photography"> Photography</label><br>
                    <input type="checkbox" id="historical" name="subcategory_id[]" value="51">
                    <label for="historical"> Historical</label><br>

                    <input type="checkbox" id="political" name="subcategory_id[]" value="61">
                    <label for="political"> Political</label><br>
                    <input type="checkbox" id="environmental" name="subcategory_id[]" value="71">
                    <label for="environmental"> Environmental</label><br>
                    <input type="checkbox" id="educational" name="subcategory_id[]" value="81">
                    <label for="educational"> Educational</label><br>

                    <input type="checkbox" id="musical" name="subcategory_id[]" value="91">
                    <label for="musical"> Musical</label><br>
                    <input type="checkbox" id="environmental" name="subcategory_id[]" value="101">
                    <label for="environmental"> Environmental</label><br>
                    <input type="checkbox" id="social" name="subcategory_id[]" value="111">
                    <label for="social"> Social</label><br>

                    <input type="checkbox" id="fps" name="subcategory_id[]" value="121">
                    <label for="fps"> FPS</label><br>
                    <input type="checkbox" id="rpg" name="subcategory_id[]" value="131">
                    <label for="rpg"> RPG</label><br>
                    <input type="checkbox" id="moba" name="subcategory_id[]" value="141">
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