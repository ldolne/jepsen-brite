<?php $title = 'sign Up'; ?>

<?php ob_start(); ?>

<main role="main" class="container">
  <div class="row">

    <div class="col-md-12">

      <form action="./index.php?action=inscription" method="post">
        <div class="form-group">

          <label for="exampleInputEmail1">
            Email address
          </label>
          <input name="email" type="text" class="form-control" id="exampleInputEmail1" value="<?php if(isset($_POST['email'])){ echo $_POST['email'];} ?>" >

        </div>
        <?= $emailError ?>
        <div class="form-group">
          <label type="pseudo" for="Pseudo">
            Pseudo
          </label>
          <input name="username" type="pseudo" class="form-control" id="exampleInputPseudo1" value="<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>">

        </div>
        <?= $usernameError ?>
        <div class="form-group">

          <label for="exampleInputPassword1">
            Password
          </label>
          <input name="password" type="password" class="form-control" id="exampleInputPassword1">

        </div>
        <?= $passwordError ?>
        <div class="form-group">

          <label for="exampleInputPassword1">
            Comfirm Password
          </label>
          <input name="passwordcheck" type="password" class="form-control" id="exampleInputPassword1">

        </div>

        <!-- <div class="checkbox">
            <label>
              <input type="checkbox"> Check me out
            </label>
          </div> -->
        <input value="Sign up" name="signup" type="submit" class="btn btn-primary">
      </form>

    </div>
  </div><!-- /.row -->

</main><!-- /.container -->


</body>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>