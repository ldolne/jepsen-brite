<?php $title = ' add event'; ?>

<?php ob_start(); ?>
   
<?php 
    require('./vendor/erusev/parsedown/Parsedown.php');
    $parsdown = new Parsedown();
    ?>
<main role="main" class="container">
    <div class="row">

        <div class="col-md-12">
            <form role="form" action="./index.php?action=createNewEvent" method="POST" enctype="multipart/form-data">
                <h2>Add event</h2>
                <div class="form-group">
                    <label for="title">Name:</label>
                    <input id="title" type="text" name="title" id="title" class="form-control">
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" name="event_date" id="date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="hour">Time:</label>
                    <input type="time" name="event_hour" id="hour" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Description:</label>
         <?php echo $parsdown->text  ('<textarea name="description" id="description" rows="5" cols="33" class="form-control"></textarea>')?>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category_id" class="form-control" id="category">
                        <option value="1">Concert</option>
                        <option value="2">Exhibition</option>
                        <option value="3">Conference</option>
                        <option value="4">Hackathon</option>
                        <option value="5">Game Jam</option>
                    </select>
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