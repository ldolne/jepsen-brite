<!-- COMMENTS ONLY FOR LOGGED USERS ; CREATION, UPDATE AND DELETE ONLY FOR LOGGED OWNER -->

<?php $title = 'Event Creation Page'; ?>

<?php ob_start(); ?>
<h1>Create an event:</h1>
<p><a href="./index_laeti.php">Back to the homepage</a></p>

<div class="createEvent">
    <form action="./index_laeti.php?action=updateExistingEvent" method="POST" enctype="multipart/form-data">
        <label for="title">Title: </label><input type="text" name="title" id="title"><br><br>
        <label for="author">Author: </label><input type="text" name="author_id" id="author"><br><br>
        <label for="date">Date and time: </label><input type="date" name="event_date" id="date"><br><br>
        <label for="image">Image: </label><input type="file" name="image" id="image"><br><br>
        <label for="description">Description: </label><textarea name="description" id="description" rows="5" cols="33">Type in the description of your event.</textarea><br><br>
        <label for="category">Category: </label>
        <div>
            <input type="radio" id="cat1" name="category_id" value="1">
            <label for="cat1">Concert</label><br>
            <input type="radio" id="cat2" name="category_id" value="2">
            <label for="cat2">Exhibition</label><br>
            <input type="radio" id="cat3" name="category_id" value="3">
            <label for="cat3">Conference</label><br>
            <input type="radio" id="cat4" name="category_id" value="4">
            <label for="cat4">Hackathon</label><br>
            <input type="radio" id="cat5" name="category_id" value="5">
            <label for="cat5">Game Jam</label><br>
        </div>
        <input type="submit" value="Submit"><br>
        <?= $message ?>
    </form>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('template_laeti.php'); ?>