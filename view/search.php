<?php $title = 'search'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">

        <div class="col-md-12">

            <form role="form">
                <h2>Search event by</h2>

                <div class="form-group">
                    <label>Event type </label>
                    <select name="categories" class="form-control">
                        <option value="all">All</option>
                        <option value="1">Concert</option>
                        <option value="2">Exhibition</option>
                        <option value="3">Conference</option>
                        <option value="4">Hackathon</option>
                        <option value="5">Game Jam</option>
                    </select>
                </div>
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
                <button type="submit" class="btn btn-primary">
                    Search
                </button>
            </form>
        </div>
    </div><!-- /.row -->

</main><!-- /.container -->
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>