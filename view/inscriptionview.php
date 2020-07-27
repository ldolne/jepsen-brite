<?= $message ?>
<form action="./indexchris.php?action=inscription" method="post">
    <input type="text" name="username" placeholder="nom d'utilisateur">
    <?= $usernameError ?><br>
    <input type="text" name="email" placeholder="user@email.com">
    <?= $emailError ?><br>
    <input type="password" name="password" placeholder="password">
    <?= $passwordError ?><br>
    <input type="password" name="passwordcheck" placeholder="vérification"><br>
    <input type="submit" name="signup" value="Sign up">
</form>