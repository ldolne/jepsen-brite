<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.0.1">

    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/blog/">
    <link href="public/css/bootstrap.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link href="public/css/blog.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/base.css">

    <title><?= $title ?></title>
</head>

<body>
    <div class="container">
        <?php require('./view/header.php') ?>
        <?php require('./view/nav-bar.php') ?>

        <?php
        if (isset($message))
        {
            echo $message;
        }
        ?>
        <?= $content ?>
    </div>
    <?php require('./view/footer.php') ?>
</body>

</html>