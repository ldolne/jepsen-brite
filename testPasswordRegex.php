<?php

if(isset($_POST['password']))
{
    if(preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password']))
    {
        echo 'Password ok';
    }
    else
    {
        echo 'Password not safe enough';
    }
}
else
{
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="POST">
    <input type="text" name="password">
    <input type="submit" value="Submit">
</form>
</body>
</html>

<?php
}
?>