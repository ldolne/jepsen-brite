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

    <!-- Bootstrap core CSS -->
    <link href="./public/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="./public/css/base.css">
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="./public/css/blog.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php require('./view/header.php') ?>
        <?php require('./view/nav-bar.php') ?>
    </div>

    </div>

    <main role="main" class="container">
        <div class="row">

            <div class="col-md-12">

                <form role="form">
                    <h2>Search event by</h2>
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
                        <label>Event type </label>
                        <select name="categories" class="form-control" id="exampleSelect1">
                            <option value="Concert">Concert</option>
                            <option value="Exhibition">Exhibition</option>
                            <option value="">Conference</option>
                            <option value="Conference">Hackathon</option>
                            <option value="Game Jam">Game Jam</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>
            </div>
        </div><!-- /.row -->

    </main><!-- /.container -->

    <?php require('./view/footer.php') ?>
</body>

</html>