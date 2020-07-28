<?php $title = 'Modify Profile'; ?>
<?php ob_start(); ?>
<?= $message ?>
<!-- <form action="./indexchris.php?action=modifyprofile" method="post">
    <input type="text" name="username" placeholder="username">
    <?= $usernameError ?><br>
    <input type="password" name="password" placeholder="password">
    <?= $passwordError ?><br>
    <input type="passwordcheck" name="passwordcheck" placeholder="password"><br>
    <input type="submit" name="modify" value="Modify">
</form> -->

<main role="main" class="container">
    <div class="row">

        <div class="col-md-12">
            <h2>
                <?= $message ?>
            </h2>

            <form action="./index.php?action=modifyprofile" method="post">
                <div class="form-group">
                    <label type="pseudo" for="Pseudo">
                       Username
                    </label>
                    <input name="username" type="pseudo" class="form-control" id="exampleInputPseudo1">

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

                <input value="Modify" name="modify" type="submit" class="btn btn-primary">
            </form>

        </div>
    </div><!-- /.row -->

</main><!-- /.container -->
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>