<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="./public/css/style.css" rel="stylesheet" />
</head>

<body>
<?= $content ?>
<?php
if(isset($errorMsg))
{
    require('errorView.php');
} ?>
</body>
</html>