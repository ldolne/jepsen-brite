<a href="indexchris.php?action=inscription">Sign up</a>
<a href="indexchris.php?action=profilesettings">profile</a>
<?php 
if (empty($_SESSION['username'])){
    ?>
    <a href="indexchris.php?action=connection">se connecter</a>
    <?php 
}

if (!empty($_SESSION['username'])){
    ?>
    <a href="indexchris.php?action=profile">Profile</a>
    <a href="indexchris.php?action=deconnection">se déconnecter</a>
    <p>bonjour <?= $_SESSION['username']; ?></p>
    <?php
}
?>