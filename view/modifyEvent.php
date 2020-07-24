<?php $title = 'modify event'; ?>

<?php ob_start(); ?>

<body>

    </div>

    <main role="main" class="container">
        <div class="row">

            <div class="col-md-12">

                <form role="form">
                    <h2>Modify event</h2>
                    <div class="form-group">
                        <label for="exampleInputName">
                            Event's Name
                        </label>
                        <input type="name" class="form-control" id="exampleInputName1">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPlace">
                            Place's Name
                        </label>
                        <input type="name" class="form-control" id="exampleInputPlace1">
                    </div>
                    <div class="form-group">
                        <label type="date" for="date">
                            Date and Hour
                        </label>
                        <input type="datetime-local" class="form-control" id="exampleInputDate1">
                    </div>
                    <div class="form-group">
                        <label type="text" for="text">
                            Description
                        </label>
                        <textarea type="textarea" class="form-control" id="exampleInputDate1"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Event type </label>
                        <select name="categories" class="form-control" id="exampleSelect1">
                            <option value="Concert">Concert</option>
                            <option value="Exhibition">Exhibition</option>
                            <option value="">Conference</option>
                            <option value="Conference">Hackathon</option>
                            <option value="Game Jam">Game Jam</option>
                        </select>
                    </div>

                    <div class="form-group">

                        <label for="exampleInputFile">
                            Image
                        </label>
                        <input type="file" class="form-control-file" id="exampleInputFile">
                        <p class="help-block">
                            Image of your event
                        </p>
                    </div>
                    <div class="checkbox">

                        <label>
                            <input type="checkbox"> Check me out
                        </label>
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
