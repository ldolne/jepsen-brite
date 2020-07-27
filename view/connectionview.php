<!DOCTYPE html>
<html>

    <head>
    </head>

    <body>
        <?= $message ?>
        <form action="./indexchris.php?action=connection" method="post">
            <input type="text" name="username" placeholder="username">
            <input type="password" name="password" placeholder="password">
            <input type="checkbox" name="stayconnected">
            <input type="submit" value="Se connecter">
        </form>
        <a href="indexchris.php">retour à la page principale</a>
    </body>

</html>