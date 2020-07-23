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
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
  <link href="./public/css/blog.css" rel="stylesheet">
  <link rel="stylesheet" href="../public/css/base.css">
</head>

<body>
  <div class="container">
    <?php require('./view/header.php') ?>
    <?php require('./view/nav-bar.php') ?> </div>

  </div>

  <main role="main" class="container">
    <div class="row">

      <div class="col-md-12">
        <?php
        if (isset($_POST['signup'])) {
          $inscription->execute(array($_POST['username'], $_POST['email']));
          $data = $inscription->fetchAll(\PDO::FETCH_ASSOC);
          // print_r($data);
          $datanamecol = array_column($data, 'username');
          $dataeamailcol = array_column($data, 'email');
          // print_r($dataeamailcol);
          // print_r($datanamecol);

        }

        if (isset($_POST['signup'], $_POST['username'], $_POST['email'], $_POST['password'], $_POST['passwordcheck']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) && $_POST['password'] == $_POST['passwordcheck'] && $_POST['password'] != null && $data == NULL && preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password'])) {
          echo "Enregistrement fait";
        } else {
        ?>
          <form action="./index.php?action=inscription" method="post">
            <div class="form-group">

              <label for="exampleInputEmail1">
                Email address
              </label>
              <input name="email" type="text" class="form-control" id="exampleInputEmail1">
              <?php
              if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
                echo ("Ce n'est pas une adresse valide");
              ?>
                <br>
              <?php
              }
              ?>
              <?php
              if (isset($_POST['signup'])) {
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
            </div>
            <div class="form-group">
              <label type="pseudo" for="Pseudo">
                Pseudo
              </label>
              <input name="username" type="pseudo" class="form-control" id="exampleInputPseudo1">
              <?php
              if (isset($_POST['signup'])) {
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
            </div>
            <div class="form-group">

              <label for="exampleInputPassword1">
                Password
              </label>
              <input name="password" type="password" class="form-control" id="exampleInputPassword1">
              <?php
              if (isset($_POST['password']) && preg_match('#^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]).{8,}$#', $_POST['password']) != TRUE) {
                echo ("Le mot de passe n'est pas suffisamment sécurisé.");
              ?>
                <br>
              <?php
              }
              ?>
            </div>

            <div class="form-group">

              <label for="exampleInputPassword1">
                Comfirm Password
              </label>
              <input name="passwordcheck" type="password" class="form-control" id="exampleInputPassword1">
              <?php
              if (isset($_POST['password']) && $_POST['password'] != $_POST['passwordcheck']) {
                echo ("les champs mot de passe ne sont pas identiques");
              ?>
                <br>
              <?php
              }
              ?>
            </div>

            <!-- <div class="checkbox">
            <label>
              <input type="checkbox"> Check me out
            </label>
          </div> -->
            <input value="Sign up" name="signup" type="submit" class="btn btn-primary">
          </form>
        <?php
        }

        ?>
      </div>
    </div><!-- /.row -->

  </main><!-- /.container -->


</body>
<?php require('./view/footer.php') ?>

</html>