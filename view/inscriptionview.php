<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php
        if (isset($_POST['signup'])){
            $inscription -> execute(array($_POST['username'], $_POST['email']));
            $data = $inscription->fetchAll(\PDO::FETCH_ASSOC);
            // print_r($data);
            $datanamecol= array_column($data, 'username');
            $dataeamailcol = array_column($data, 'email');
            // print_r($dataeamailcol);
            // print_r($datanamecol);

        }

        if (isset($_POST['signup'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['passwordcheck']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['password'] == $_POST['passwordcheck'] && $_POST['password'] != null && $data==NULL && preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password'])){
            echo "Enregistrement fait";
        }
        else {
            ?>
            <form action="./indexchris.php?action=inscription" method="post">
                <input type="text" name="username" placeholder="nom d'utilisateur"><br>
                <?php
                if (isset($_POST['signup'])){
                    foreach ($datanamecol as $value) {
                        if (isset($_POST['username']) && $value == $_POST['username']) {
                            echo ("Ce nom d'utilisateur est déjà pris");
                            ?>
                            <br>
                            <?php
                        }
                    }
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
                if (isset($_POST['signup'])){
                    foreach ($dataeamailcol as $value) {
                        if (isset($_POST['email']) && $value == $_POST['email']) {
                            echo ("Cette adresse mail est déjà associée à un compte.");
                            ?>
                            <br>
                            <?php
    
                        }
                    }
                }
                
                ?>
                <input type="password" name="password" placeholder="password"><br>
                <?php
                if (isset($_POST['password']) && preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password']) != TRUE) {
                    echo ("Le mot de passe n'est pas suffisamment sécurisé.");
                    ?>
                    <br>
                    <?php
                }
                ?>
                
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