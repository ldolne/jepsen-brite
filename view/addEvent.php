<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">
    <title>Jepsen Brite Team 5</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/blog/">

    <?php require('../require/css.php') ?>
</head>

<body>
    <div class="container">
        <?php require('../require/header.php') ?>
        <?php require('../require/nav-bar.php') ?>
    </div>

    </div>

    <main role="main" class="container">
        <div class="row">

            <div class="col-md-12">
                <form role="form">
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
                        <select class="form-control" id="exampleSelect1">
                            <option>Concert</option>
                            <option>Party</option>
                            <option>Conferance</option>
                            <option>Something</option>
                            <option>Other</option>
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

    <?php require('../require/footer.php') ?>
</body>

</html>