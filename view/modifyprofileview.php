<?= $message ?>
<form action="./indexchris.php?action=modifyprofile" method="post">
    <input type="text" name="username" placeholder="username">
    <?= $usernameError ?><br>
    <input type="password" name="password" placeholder="password">
    <?= $passwordError ?><br>
    <input type="passwordcheck" name="passwordcheck" placeholder="password"><br>
    <input type="submit" name="modify" value="Modify">
</form>
<a href="indexchris.php">retour à la page principale</a>