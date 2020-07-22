<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php
        $inscription -> execute(array($_POST['username'], $_POST['email']));
        $data = $inscription->fetchAll(\PDO::FETCH_ASSOC);
        print_r($data);

        if (isset($_POST['signup'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['passwordcheck']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['password'] == $_POST['passwordcheck'] && $_POST['password'] != null && isset($data['username'])==false && isset($data['email'])==false){
            echo "Enregistrement fait";
        }
        else {
            ?>
            <form action="./indexchris.php?action=inscription" method="post">
                <input type="text" name="username" placeholder="nom d'utilisateur"><br>
                <?php
                
                    if (isset($_POST['username']) && $value == $_POST['username']) {
                        echo ("Ce nom d'utilisateur est déjà pris");
                        ?>
                        <br>
                        <?php
                    }
                
                ?>
                <input type="text" name="email" placeholder="user@email.com"><br>
                <?php
                if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)==false ) {
                    echo ("Ce n'est pas une adresse valide");
                    ?>
                    <br>
                    <?php   
                }
                ?>
                <?php
                
                    if (isset($_POST['email']) && $value == $_POST['email']) {
                        echo ("Cette adresse mail est déjà associée à un compte.");
                        ?>
                        <br>
                        <?php

                    }
                
                ?>
                <input type="password" name="password" placeholder="password"><br>
                <input type="password" name="passwordcheck" placeholder="vérification"><br>
                <?php
                if (isset($_POST['password']) && $_POST['password'] != $_POST['passwordcheck']) {
                    echo ("les champs mot de passe ne sont pas identiques");
                    ?>
                    <br>
                    <?php
                }
                ?>
                <input type="submit" name="signup" value="Sign up">
            </form>
            <?php
        }
        ?>

    </body>
</html>