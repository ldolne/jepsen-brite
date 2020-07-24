<?php $title = 'loging'; ?>

<?php ob_start(); ?>


  <main role="main" class="container">
    <div class="row">

      <div class="col-md-12">
        <form role="form">
          <div class="form-group">

            <label for="exampleInputEmail1">
              Email address
            </label>
            <input type="email" class="form-control" id="exampleInputEmail1">
          </div>
          <div class="form-group">

            <label for="exampleInputPassword1">
              Password
            </label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>

          <div class="checkbox">

            <label>
              <input type="checkbox"> Check me out
            </label>
          </div>
          <button type="submit" class="btn btn-primary">
            Submit
          </button>
        </form>
      </div>
    </div><!-- /.row -->

  </main><!-- /.container -->
  <?php $content = ob_get_clean(); ?>
  <?php require('template.php'); ?>
