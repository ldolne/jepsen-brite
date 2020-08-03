<?php $title = 'Modify Profile'; ?>
<?php ob_start(); ?>

<main role="main" class="container">
    <div class="row">

        <div class="col-md-12">
            <form action="./index.php?action=modifyprofile" method="post">
                <div class="form-group">
                    <label type="pseudo" for="Pseudo">
                       Username
                    </label>
                    <input name="username" type="pseudo" class="form-control" id="exampleInputPseudo1"value="<?php if(isset($_POST['username'])){ echo $_POST['username'];} ?>">

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
                        Confirm Password
                    </label>
                    <input name="passwordcheck" type="password" class="form-control" id="exampleInputPassword1">

                </div>

                <input value="Modify" name="modify" type="submit" class="btn btn-primary">
            </form>

        </div>
    </div><!-- /.row -->

</main><!-- /.container -->
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>