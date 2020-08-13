<?php $title = 'Login'; ?>

<?php ob_start(); ?>
  <main role="main" class="container" style="color: white;">
    <div class="row">

      <div class="col-md-12">
      
        <form role="form" method="post" action="index.php?action=connection">
          <div class="form-group">

            <label for="exampleInputEmail1">
              Username
            </label>
            <input type="text" name="username" class="form-control" id="exampleInputEmail1">
          </div>
          <div class="form-group">

            <label for="exampleInputPassword1">
              Password
            </label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1">
          </div>

          <div class="checkbox">

            <label>
              <input type="checkbox" name="stayconnected"> Stay connected
            </label>
          </div>
          <input type="submit" value ="Connection" class="btn btn-primary">
        </form>
      </div>
    </div><!-- /.row -->

  </main><!-- /.container -->
  <?php $content = ob_get_clean(); ?>
  <?php require('template.php'); ?>
